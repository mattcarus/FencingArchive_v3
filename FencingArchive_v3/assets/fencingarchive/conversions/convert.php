<?php

	$longopts  = array(
			"url:",
			"debug",
			"database"
	);
	$opt = getopt("", $longopts);

  // Autoload conversion classes
  spl_autoload_register(function ($class) {
	include 'convert.' . $class . '.php';
  });

  $file = $opt['url'];

  require_once 'simplehtml.class.php';
  require_once '../definitions.php';
  require_once '../FA.database.class.php';
  
  // Load list of conversion classes
  $conversions = glob("convert.*.php");
  
  logMessage("", sprintf("Loaded %d conversion classes", count($conversions)));
  
  for($i = 0; $i < count($conversions); $i++)
  {
  	$conversions[$i] = str_replace(array("convert.", ".php"), "", $conversions[$i]);
  }
  
  try {
  	$html = file_get_html($file);
  } catch (Exception $e) {
  	echo $e->getTraceAsString();
  }
  
  if ( !is_object($html) )
  {
  	die("ERROR: File could not be interpreted as HTML :(\n");
  }
  
  foreach ( $conversions as $conversion )
  {
  	$comp = new $conversion();
  	if ( $comp->isValid($html) )
  	{
  		logMessage("ok", "Valid $conversion");
  		$comp->parse($html);
		$comp->setWeapon($comp->guessWeapon());
		$comp->setCategory($comp->guessCategory());
		//$compDate = find_date($comp->name);
		$compDate = find_date($html->plaintext);
		$comp->setDate(sprintf("%04d_%02d_%02d", $compDate['year'], $compDate['month'], $compDate['day']));

		echo $comp->getFilename();
		echo "\n";
		echo $comp->getCSV();
		break;
  	}
  	else
  	{
  		logMessage("error", "Invalid $conversion");
  	}
  }
  
  if ( isset($opt['debug']) )
  {
  	logMessage("", "Debug flag set");
  	$comp->prepForDatabase();
  }

  if ( isset($opt['database']) )
  {
  	logMessage("", "Database flag set");
  }

  function cleanup($str)
  {
  	$str = str_ireplace("(vet)", "", $str);
  	$str = str_replace("&nbsp;", "", $str);
  	$str = str_replace("*", "", $str);
  	$str = str_replace("\n", "", $str);
  	$str = preg_replace('!\s+!', ' ', $str);
  	$str = trim($str);
  	return $str;
  }
  
  function logMessage($level, $message)
  {
  	$status = "[*]";
  	if ( $level == "ok" )
  	{
  		$status = "[+]";
  	}
  	elseif ( $level == "error" )
  	{
  		$status = "[-]";
  	}
  	
  	echo sprintf("%s %s\n", $status, $message); 
  }
  
  function find_date( $string ) {  
  	//Define month name:
  	$month_names = array(
  			"january",
  			"february",
  			"march",
  			"april",
  			"may",
  			"june",
  			"july",
  			"august",
  			"september",
  			"october",
  			"november",
  			"december"
  	);
  
  	$month_number=$month=$matches_year=$year=$matches_month_number=$matches_month_word=$matches_day_number="";
  
  	//Match dates: 01/01/2012 or 30-12-11 or 1 2 1985
  	preg_match( '/([0-9]?[0-9])[\.\-\/ ]?([0-1]?[0-9])[\.\-\/ ]?([0-9]{2,4})/', $string, $matches );
  	if ( $matches ) {
  		if ( $matches[1] )
  			$day = $matches[1];
  
  		if ( $matches[2] )
  			$month = $matches[2];
  
  		if ( $matches[3] )
  			$year = $matches[3];
  	}
  
  	//Match month name:
  	preg_match( '/(' . implode( '|', $month_names ) . ')/i', $string, $matches_month_word );
  
  	if ( $matches_month_word ) {
  		if ( $matches_month_word[1] )
  			$month = array_search( strtolower( $matches_month_word[1] ),  $month_names ) + 1;
  	}
  
  	//Match 5th 1st day:
  	preg_match( '/([0-9]?[0-9])(st|nd|th)/', $string, $matches_day );
  	if ( $matches_day ) {
  		if ( $matches_day[1] )
  			$day = $matches_day[1];
  	}
  
  	//Match Year if not already setted:
  	if ( empty( $year ) ) {
  		preg_match( '/[0-9]{4}/', $string, $matches_year );
  		if ( $matches_year[0] )
  			$year = $matches_year[0];
  	}
  	if ( ! empty ( $day ) && ! empty ( $month ) && empty( $year ) ) {
  		preg_match( '/[0-9]{2}/', $string, $matches_year );
  		if ( $matches_year[0] )
  			$year = $matches_year[0];
  	}
  
  	//Leading 0
  	if ( 1 == strlen( $day ) )
  		$day = '0' . $day;
  
  	//Leading 0
  	if ( 1 == strlen( $month ) )
  		$month = '0' . $month;
  
  	//Check year:
  	if ( 2 == strlen( $year ) && $year > 20 )
  		$year = '19' . $year;
  	else if ( 2 == strlen( $year ) && $year < 20 )
  		$year = '20' . $year;
  
  	$date = array(
  			'year' 	=> $year,
  			'month' => $month,
  			'day' 	=> $day
  	);
  
  	//Return false if nothing found:
  	if ( empty( $year ) && empty( $month ) && empty( $day ) )
  		return false;
  	else
  		return $date;
  }

  class ResultCSV
  {
  	public $position;
  	public $surname;
  	public $forename;
  	public $club;
  	public $nationality;
  	
  	function setAttribute($attr, $value)
  	{
  		switch ($attr)
  		{
  			case "Ranking":
  			case "Rank":
  			case "Place":
  			case "Pos":
  				$this->setPosition($value);
  				break;
  			case "Name":
  			case "Surname":
  				$this->setSurname($value);
  				break;
  			case "First name":
  				$this->setForename($value);
  				break;
  			case "Country":
  				$this->setNationality($value);
  				break;
  			case "Club":
  			case "Club(s)":
  				$this->setClub($value);
  				break;
  		}
  	}
  	
  	function setPosition($position)
  	{
  		if($position == "3T")
  		{
  			$position = "3";
  		}
  		$this->position = $position;
  	}
  	
  	function getPosition()
  	{
  		return $this->position;
  	}
  	
  	function setSurname($surname)
  	{
  		$this->surname = strtoupper($surname);
  	}
  	
  	function getSurname()
  	{
  		return $this->surname;
  	}
  	
  	function setForename($forename)
  	{
  		$this->forename = $forename;
  	}
  	
  	function getForename()
  	{
  		return $this->forename;
  	}
  	
  	function setClub($club)
  	{
  		$this->club = $club;
  	}
  	
  	function getClub()
  	{
  		return $this->club;
  	}
  	
  	function setNationality($nationality)
  	{
  		$this->nationality = $nationality;
  	}
  	
  	function getNationality()
  	{
  		return $this->nationality;
  	}
  	
  	function getCSV()
  	{
  		return sprintf("%d,\"%s\",\"%s\",,\"%s\",\"%s\"", $this->position, $this->surname, $this->forename, $this->club, $this->nationality);
  	}
  	
  	function getDatabaseId()
  	{
  		$db = new Database();

  		logMessage("", sprintf("Checking %s, %s", $this->getSurname(), $this->getForename()));
  			
  		$dbRes = $db->query(sprintf("SELECT id FROM `fencers` WHERE `surname`='%s' AND `forename`='%s';", $this->getSurname(), $this->getForename()));
  		if ( !mysql_num_rows($dbRes) )
  		{
  			logMessage("error", sprintf("%s, %s not in database", $this->getSurname(), $this->getForename()));
  			return false;
  		}
  		else
  		{
  			logMessage("ok", sprintf("%s, %s is in database", $this->getSurname(), $this->getForename()));
  			
  			return mysql_result($dbRes, 0);
  		}
  	}
  	
  	function addToDatabase()
  	{
  		if ( !$this->getDatabaseId() )
  		{
  			$db = new Database();
  			$sql = sprintf("INSERT INTO `fencers` (`surname`, `forename`) VALUES ('%s', '%s');", $this->getSurname(), $this->getForename());
  			logMessage("", "Executing query " . $sql);
  			//$db->query($sql);
  		}
  	}
  }
  
  class CompetitionCSV
  {
  	public $cid = '';
  	public $name = '';
  	public $weapon = '';
  	public $category = '';
  	public $results = array();
  	public $date = '';
  	
  	function __construct()
  	{

  	}
  	
  	function setName($name)
  	{
  		$this->name = $name;
  	}
  	
  	function setWeapon($weapon)
  	{
  		$this->weapon = $weapon;
  	}
  	
  	function setCategory($category)
  	{
  		$this->category = $category;
  	}
  	
  	function setDate($date)
  	{
  		$this->date = $date;
  	}
  	
  	function addResult($result)
  	{
  		array_push($this->results, $result);
  	}
  	
  	function getFilename()
  	{
  		return sprintf("%s-%s-%s-%s.csv", str_replace(" ", "_", $this->name), $this->weapon, $this->category, $this->date);
  	}
  	
  	function getCSV()
  	{
  		$csv = "position,surname,forename,dob,club,nationality\n";
  		foreach ( $this->results as $res )
  		{
  			$csv .= $res->getCSV() . "\n";
  		}
  		return $csv;
  	}
  	
  	function guessCategory()
  	{
  		$name = strtolower($this->name);
  		
  		if ( strpos($name, "u8") !== false || strpos($name, "under 8") !== false )
  		{
  			$cat = "u8";
  		}
  		elseif ( strpos($name, "u9") !== false || strpos($name, "under 9") !== false )
  		{
  			$cat = "u9";
  		}
  		elseif ( strpos($name, "u10") !== false || strpos($name, "under 10") !== false )
  		{
  			$cat = "u10";
  		}
  		elseif ( strpos($name, "u11") !== false || strpos($name, "under 11") !== false )
  		{
  			$cat = "u11";
  		}
	  	elseif ( strpos($name, "u12") !== false || strpos($name, "under 12") !== false )
  		{
  			$cat = "u12";
  		}
  		elseif ( strpos($name, "u13") !== false || strpos($name, "under 13") !== false )
  		{
  			$cat = "u13";
  		}
  		elseif ( strpos($name, "u14") !== false || strpos($name, "under 14") !== false )
  		{
  			$cat = "u14";
  		}
  		elseif ( strpos($name, "u15") !== false || strpos($name, "under 15") !== false )
  		{
  			$cat = "u15";
  		}
  		elseif ( strpos($name, "u16") !== false || strpos($name, "under 16") !== false )
  		{
  			$cat = "u16";
  		}
  		elseif ( strpos($name, "u17") !== false || strpos($name, "under 17") !== false || strpos($name, "cadet") !== false )
  		{
  			$cat = "cadet";
  		}
  		elseif ( strpos($name, "u18") !== false || strpos($name, "under 18") !== false )
  		{
  			$cat = "u18";
  		}
  		elseif ( strpos($name, "u19") !== false || strpos($name, "under 19") !== false )
  		{
  			$cat = "u19";
  		}
  		elseif ( strpos($name, "u20") !== false || strpos($name, "under 20") !== false || strpos($name, "junior") !== false )
  		{
  			$cat = "junior";
  		}
  		elseif ( strpos($name, "vet") !== false )
  		{
  			$cat = "vet";
  		}
  		else
  		{
  			$cat = "open";
  		}
  		return $cat;
  	}
  	
  	function guessWeapon()
  	{
  		$name = strtolower($this->name);
  		
  		if ( strpos($name, "women") !== false
  				|| strpos($name, "female") !== false
  				|| strpos($name, "girl") !== false
  			)
  		{
  			$gender = "W";
  		}
  		elseif ( strpos($name, "men") !== false
  				|| strpos($name, "male") !== false
  				|| strpos($name, "boy") !== false
  			)
  		{
  			$gender = "M";
  		}
  		else
  		{
  			$gender = "X";
  		}
  		
  		if ( strpos($name, "sabre") !== false
  				|| strpos($name, "saber") !== false
  			)
  		{
  			$sword = "S";
  		}
  		elseif ( strpos($name, "epee") !== false
  				|| strpos($name, "epee") !== false
  			)
  		{
  			$sword = "E";
  		}
  		elseif ( strpos($name, "foil") !== false )
  		{
  			$sword = "F";
  		}
  		else
  		{
  			$sword = "X";
  		}
  		
  		return "$gender$sword";
  	}
  	
  	function prepForDatabase()
  	{
  		
  		// Check that fencers are present in the database and record their IDs
  		
  		foreach ( $this->results as $result )
  		{
  			logMessage("", sprintf("ID for %s, %s is %d", $result->getSurname(), $result->getForename(), $result->getDatabaseId()));
  		}
  	}
  }
?>