<?php
class NewFencingTimeCompetition extends CompetitionCSV
{
	function isValid($html)
	{
		if ( is_object($html) )
		{
			if ( strpos($html->plaintext, "Fencing Time v4") )
			{
				return true;
			}
		}
		return false;
	}

	function parse($html)
	{
		$this->setName(cleanup($html->find('span.tournName', 0)->plaintext));

		$headerOrder = array();

		foreach($html->find('table.dataTable', 0)->find('tr') as $resultsHtml)
		{
			foreach($resultsHtml->find('th') as $element)
			{
				$headerOrder[] = cleanup($element->plaintext);
			}
		}

		foreach($html->find('table.dataTable', 0)->find('tr') as $resultsHtml)
		{
			if (!$resultsHtml->find('th'))
			{
				$result = new ResultCSV();
				$i = 0;
				foreach($resultsHtml->find('td') as $element)
				{
					// For FencingTime, need to split the name
					if ($headerOrder[$i] == "Name")
					{
						list($surname, $forename) = split(", ", $element->plaintext);
						$result->setSurname(cleanup($surname));
						$result->setForename(cleanup($forename));
					}
					else
					{
						$result->setAttribute($headerOrder[$i], cleanup($element->plaintext));
					}
					$i++;
				}
				$this->addResult($result);
			}
		}
	}
}
?>