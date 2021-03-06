<?php
/*	FencingArchive.net API Client Class
 *
 *	Version 0.1b
 */

class AdHocQueries
{
	public function lastNCompetitionLinks($offset, $number)
	{
		$db = new Database();
		
		$results = $db->query("SELECT `id` FROM `competitions` ORDER BY `date` DESC LIMIT " . $offset . ", " . $number . ";");
		
		$competitions = array();
		while ( $row = mysql_fetch_assoc($results) )
		{
			$comp = new Competition($row['id']);
			array_push($competitions, $comp->getLink());
		}
		return $competitions;
	}
	
	public function recentSeries()
	{
		$db = new Database();
		
		$results = $db->query("SELECT * FROM series INNER JOIN (SELECT MAX(id) AS id FROM series GROUP BY name, weapon) ids ON series.id = ids.id ORDER BY name, weapon, date DESC;");
		
		$series = array();
		while ( $row = mysql_fetch_assoc($results) )
		{
			array_push($series, array("id" => $row['id'], "name" => $row['name'], "weapon" => $row['weapon'], "date" => $row['date'], "views" => $row['views']));
		}
		return $series;
	}
	
}
?>