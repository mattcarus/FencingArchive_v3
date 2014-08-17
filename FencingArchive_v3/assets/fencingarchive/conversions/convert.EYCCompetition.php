<?php
class EYCCompetition extends CompetitionCSV
{
	function isValid($html)
	{
		if ( is_object($html) )
		{
			if ( strpos($html->plaintext, "EYC") )
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
			$this->setName(cleanup($html->find('title', 0)->plaintext));
	
			$headerOrder = array();
			foreach($html->find('div#franking table tr') as $resultsHtml)
			{
				foreach($resultsHtml->find('th') as $element)
				{
					$headerOrder[] = cleanup($element->plaintext);
				}
			}
	
			foreach($html->find('div#franking table tr') as $resultsHtml)
			{
				if (!$resultsHtml->find('th'))
				{
					$result = new ResultCSV();
					$i = 0;
					foreach($resultsHtml->find('td') as $element)
					{
						// For EYC, need to split the name
						if ($headerOrder[$i] == "Name")
						{
							$surname = array();
							$forename = array();
							$nameElements = split(" ", $element->plaintext);
							foreach ( $nameElements as $nameElement )
							{
								if ( strtoupper($nameElement) == $nameElement )
								{
									$surname[] = cleanup($nameElement);
								}
								else
								{
									$forename[] = cleanup($nameElement);
								}
							}
							$result->setSurname(implode(" ", $surname));
							$result->setForename(implode(" ", $forename));
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
		catch (Exception $e)
		{
			echo $e->getTraceAsString();
		}
	}
}
?>