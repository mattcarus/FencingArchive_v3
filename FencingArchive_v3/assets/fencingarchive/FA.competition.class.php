<?php
/*	FencingArchive.net API Client Class
 *
 *	Version 0.1b
 */

class Competition {
	public $cid = '';
	public $name = '';
	public $weapon = '';
	public $tag_url = '';
	public $results = array();
	public $date = '';
	
	function __construct($cid)
	{
		$this->getCompetition($cid);
	}

	public function getCompetition($cid) {
		$db = new Database();
		
		$row = mysql_fetch_assoc($db->query("SELECT * FROM `competitions` WHERE `id` = '$cid';"));
		
		$this->cid = $cid;
		$this->name = $row['name'];
		$this->weapon = $row['weapon'];
		$this->category = $row['category'];
		$this->date = $row['date'];
	}
	
	public function getName()
	{
		$name = $this->name;
		
		$name .= ( $this->category == "u9" ? " Under 9" : "");
		$name .= ( $this->category == "u10" ? " Under 10" : "");
		$name .= ( $this->category == "u11" ? " Under 11" : "");
		$name .= ( $this->category == "u12" ? " Under 12" : "");
		$name .= ( $this->category == "u13" ? " Under 13" : "");
		$name .= ( $this->category == "u14" ? " Under 14" : "");
		$name .= ( $this->category == "u15" ? " Under 15" : "");
		$name .= ( $this->category == "u16" ? " Under 16" : "");
		$name .= ( $this->category == "u17" ? " Under 17" : "");
		$name .= ( $this->category == "u18" ? " Under 18" : "");
		$name .= ( $this->category == "cadet" ? " Cadet" : "");
		$name .= ( $this->category == "junior" ? " Junior" : "");
		$name .= ( $this->category == "senior" ? " Senior" : "");
		$name .= ( $this->category == "veteran" ? " Veteran" : "");
		$name .= ( $this->category == "cdn" ? " Coupe du Nord" : "");
		$name .= ( $this->category == "a" ? " A-Grade" : "");
		$name .= ( $this->category == "sat" ? " Satellite" : "");
		$name .= ( $this->category == "closed" ? " Closed" : "");
		$name .= ( $this->category == "open" ? " Open" : "");
		
		$name .= ( $this->weapon == "ME" ? " Mens Epee" : "");
		$name .= ( $this->weapon == "MF" ? " Mens Foil" : "");
		$name .= ( $this->weapon == "MS" ? " Mens Sabre" : "");
		$name .= ( $this->weapon == "WE" ? " Womens Epee" : "");
		$name .= ( $this->weapon == "WF" ? " Womens Foil" : "");
		$name .= ( $this->weapon == "WS" ? " Womens Sabre" : "");
		$name .= ( $this->weapon == "XE" ? " Mixed Epee" : "");
		$name .= ( $this->weapon == "XF" ? " Mixed Foil" : "");
		$name .= ( $this->weapon == "XS" ? " Mixed Sabre" : "");
		
		$name .= " " . date("Y", strtotime($this->date));
		
		return $name;
	}
	
	public function getDate()
	{
		return $this->date;
	}
	
	public function getLink()
	{
		return "<a href=\"" . BASE_URL . "/competition.php?cid=" . $this->cid . "\">" . $this->getName() . "</a>";
	}
	
	public function getResults()
	{
		// NOTE: we don't automatically call this every time a competition object is created to avoid circular loops
		if ( isset($this->cid) )
		{
			$db = new Database();
			$results = $db->query("SELECT `position`, `fid` FROM `competitions_results.v` WHERE `cid`='" . $this->cid . "' ORDER BY `position` ASC;");

			while ( $row = mysql_fetch_assoc($results) )
			{
				$fencer = new Fencer($row['fid']);
				
				$club_links = array();
				array_push($this->results, array('position' => $row['position'], 'fencer' => new Fencer($row['fid'])));
			}
			
			return $this->results;
		}
	}
	
	public function getResultsFormatted()
	{
		$results = array();
		foreach ( $this->getResults() as $result )
		{
			array_push($results, array('position' => $result['position'], 'name' => $result['fencer']->getLink(), 'club' => $result['fencer']->getClubsPrintableInline()));
		}
		return $results;
	}

}
