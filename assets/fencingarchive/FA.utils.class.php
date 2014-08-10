<?php
/*	FencingArchive.net API Client Class
 *
 *	Version 0.1b
 */

class Utils
{
	public function arrayAsUnnumberedList($arr, $ul_class='', $ul_id='', $li_class='')
	{
		if ( $ul_class ) {
			$ul_class_html = " class=\"$ul_class\"";
		} else {
			$ul_class_html = "";
		}
		
		if ( $ul_id ) {
			$ul_id_html = " id=\"$ul_id\"";
		} else {
			$ul_id_html = "";
		}
		$html = "<ul$ul_class_html$ul_id_html>";
		
		$html .= $this->arrayAsListItems($arr, $li_class);
		
		$html .= "</ul>\n";
		
		return $html;
	}
	
	public function arrayAsListItems($arr, $li_class='', $li_id='')
	{
		$html = '';
		foreach($arr as $element)
		{
			$html .= "\t<li>$element</li>\n";
		}
		return $html;
	}
	
	public function twoDimensionArrayAsTable($arr)
	{
		$html = '';
		foreach ( $arr as $row )
		{
			$html .= "<tr>";
			foreach ( $row as $cell )
			{
				$html .= "<td>$cell</td>";
			}
			$html .= "</tr>\n";
		}
		return $html;
	}
	
	public function printTopFencers()
	{
		$adHocQueries = new AdHocQueries();
		$html = '';
		
		foreach ( $adHocQueries->recentSeries() as $sid )
		{
			$series = new Series($sid['id']);
			$html .= "<h3>" . $series->getLink() . "</h3><p>";
			foreach ( $series->getRankings(2) as $seriesRankings )
			{
				$html .= $seriesRankings['position'] . ". " . $seriesRankings['fencer']->getLink() . "<br />\n";
			}
			$html .= "</p>";
		}
		
		return $html;
	}
	
	public function formatDate($date)
	{
		if(empty($date))
		{
			return "No date provided";
		}
	 
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
	 
		$now             = time();
		date_default_timezone_set('Europe/London');
		$unix_date       = strtotime($date);
	 
		   // check validity of date
		if(empty($unix_date))
		{
			return "Bad date";
		}
	 
		// is it future date or past date
		if($now >= $unix_date)
		{
			$difference     = $now - $unix_date;
			$tense         = "ago";
	 
		}
		else
		{
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}
	 
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
		{
			$difference /= $lengths[$j];
		}
	 
		$difference = round($difference);
	 
		if($difference != 1)
		{
			$periods[$j].= "s";
		}
	 
		return "$difference $periods[$j] {$tense}";

	}
	
	public function getPageUrl()
	{
		$url = "http://" . $_SERVER['SERVER_NAME'];		// This includes a trailing slash
		
		if ( $_SERVER['PHP_SELF'] != 'index.php' )		// defeat to remove index.php
			$url .= $_SERVER['PHP_SELF'];
			
		if ( $_SERVER['QUERY_STRING'] != '' )
			$url .= "?" . $_SERVER['QUERY_STRING'];
			
		return  $url;
	}
	
	public function getCurrentUrl() {
		$pageURL = 'http';
		//if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
}

class XMLSerializer {

/**
 * 
 * The most advanced method of serialization.
 * 
 * @param mixed $obj => can be an objectm, an array or string. may contain unlimited number of subobjects and subarrays
 * @param string $wrapper => main wrapper for the xml
 * @param array (key=>value) $replacements => an array with variable and object name replacements
 * @param boolean $add_header => whether to add header to the xml string
 * @param array (key=>value) $header_params => array with additional xml tag params
 * @param string $node_name => tag name in case of numeric array key
 */
public static function generateValidXmlFromMixedObj($obj, $wrapper = null, $replacements=array(), $add_header = true, $header_params=array(), $node_name = 'node') 
{
    $xml = '';
    if($add_header)
        $xml .= self::generateHeader($header_params);
    if($wrapper!=null) $xml .= '<' . $wrapper . '>';
    if(is_object($obj))
    {
        $node_block = strtolower(get_class($obj));
        if(isset($replacements[$node_block])) $node_block = $replacements[$node_block];
        $xml .= '<' . $node_block . '>';
        $vars = get_object_vars($obj);
        if(!empty($vars))
        {
            foreach($vars as $var_id => $var)
            {
                if(isset($replacements[$var_id])) $var_id = $replacements[$var_id];
                $xml .= '<' . $var_id . '>';
                $xml .= self::generateValidXmlFromMixedObj($var, null, $replacements,  false, null, $node_name);
                $xml .= '</' . $var_id . '>';
            }
        }
        $xml .= '</' . $node_block . '>';
    }
    else if(is_array($obj))
    {
        foreach($obj as $var_id => $var)
        {
            if(!is_object($var))
            {
                if (is_numeric($var_id)) 
                    $var_id = $node_name;
                if(isset($replacements[$var_id])) $var_id = $replacements[$var_id]; 
                $xml .= '<' . $var_id . '>';    
            }   
            $xml .= self::generateValidXmlFromMixedObj($var, null, $replacements,  false, null, $node_name);
            if(!is_object($var))
                $xml .= '</' . $var_id . '>';
        }
    }
    else
    {
        $xml .= htmlspecialchars($obj, ENT_QUOTES);
    }

    if($wrapper!=null) $xml .= '</' . $wrapper . '>';

    return $xml;
}   

/**
 * 
 * xml header generator
 * @param array $params
 */
public static function generateHeader($params = array())
{
    $basic_params = array('version' => '1.0', 'encoding' => 'UTF-8');
    if(!empty($params))
        $basic_params = array_merge($basic_params,$params);

    $header = '<?xml';
    foreach($basic_params as $k=>$v)
    {
        $header .= ' '.$k.'="'.$v.'"';
    }
    $header .= ' ?>';
    return $header;
}    
}