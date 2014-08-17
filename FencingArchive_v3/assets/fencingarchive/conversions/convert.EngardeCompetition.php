<?php
class EngardeCompetition extends CompetitionCSV
{
	function isValid($html)
	{
		if ( is_object($html) )
		{
			if ( $html->find('meta[name=Originator]') )
			{
				return true;
			}
		}
		return false;
	}
	
	function parse($html)
	{
		try
		{
			$this->setName(cleanup($html->find('h1', 0)->plaintext));
	
			$headerOrder = array();
			foreach($html->find('table.liste tr') as $resultsHtml)
			{
				foreach($resultsHtml->find('th') as $element)
				{
					$headerOrder[] = cleanup($element->plaintext);
				}
			}
	
			foreach($html->find('table.liste tr') as $resultsHtml)
			{
				if (!$resultsHtml->find('th'))
				{
					$result = new ResultCSV();
					$i = 0;
					foreach($resultsHtml->find('td') as $element)
					{
						$result->setAttribute($headerOrder[$i], cleanup($element->plaintext));
						$i++;
					}
					$this->addResult($result);
				}
			}
		}
		catch (Exception $e)
		{
			echo $e->getTraceAsString();
		}
	}
}
?>