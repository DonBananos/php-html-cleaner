<?php

/*
 * The PHP_HTML_cleaner is build by Heini Ovason and Mike Jensen under the
 * MIT license. You're free to use, change and distribute the code, but can not
 * hold the developers liable. See more in license.txt
 */
class Html_cleaner
{
	private $test_string = "<p>A <b>Test</b> String<br/><ul><li>Test Point</li><li>Test Point2</li></ul></p>";
	private $whitelist = array("p", "b", "ul", "li", "u", "a", "ol", "img", "i", "br", "/p", "/b", "/ul", "/li", "/u", "/a", "/ol", "/i", "br/", "br /");
	private $string_to_clean = "";
	//Setting the allowed img attributes
	private $img_values = array();
	//Choose the accepted in function set_attributes_for_img()
	//Setting the allowed a attributes
	private $a_values = array();

	//Choose the accepted in function set_attributes_for_a()

	function __construct()
	{
		echo "<h2>You've envoked the html_cleaner class. Initiate testing punk</h2><br/>";
		$this->set_attributes_for_a();
		$this->set_attributes_for_img();
	}

	public function start_cleaning($string_to_clean, $whitelist)
	{
		if (empty($string_to_clean))
		{
			$this->string_to_clean = $this->test_string;
		}
		else
		{
			$this->string_to_clean = $string_to_clean;
		}
		if (empty($whitelist))
		{
			$this->whitelist = $this->whitelist;
		}
		else
		{
			$this->whitelist = $whitelist;
		}
		return $this->cleaner();
	}

	private function cleaner()
	{
		$clean_string = "";
		/*
		  OBS! Need to be able to hande <someWhiteListTag> + ="jadadadad
		 */
		for ($i = 0; $i < strlen($this->string_to_clean); $i++)
		{
			/* Does the index contain the string "<" ? */
			if ($this->string_to_clean[$i] === "<")
			{
				/*
				  Cool then find the preceeding index(returns an int)
				  of the next occurence of '>'.
				  stripos(Input String, Next occurence of substring, Start index)
				 */
				$nextOpenTagPos = $i;
				$nextCloseTagPos = stripos($this->string_to_clean, ">", $i);
				/* Let's jump ahead to current > in next iteration to save computation */
				$i = $nextCloseTagPos;
				$len = $nextCloseTagPos - $nextOpenTagPos + 1;
				/* Testing variables for index positions of '<' and '>' */
				/*
				  Find the substring between < and >
				  param 1: input string
				  param 2: Begin index
				  param 3: length
				 */
				$subStrBetweenTags = substr($this->string_to_clean, $nextOpenTagPos, $len);

				$clean_occurance = $this->clean_occurance($subStrBetweenTags);
				$clean_string .= $clean_occurance;
			}
			else
			{
				$clean_string .= $this->string_to_clean[$i];
			}
		}
		return $clean_string;
	}

	private function clean_occurance($occurance)
	{
		$cleaned = FALSE;

		while (!$cleaned)
		{
			//Temporarily remove < and > for testing on whitelist
			$sub_occurance = substr($occurance, 1, -1);
			if (in_array($sub_occurance, $this->whitelist))
			{
				$cleaned = TRUE;
				$clean_occurance = $occurance;
			}
			else
			{
				if ($this->check_if_blacklisted_for_values($occurance))
				{
					$clean_occurance = $occurance;
				}
				else
				{
					$clean_occurance = htmlentities($occurance);
				}
				$cleaned = TRUE;
			}
		}
		return $clean_occurance;
	}

	private function check_if_blacklisted_for_values($occurance)
	{
		if (in_array("img", $this->whitelist))
		{
			if (substr($occurance, 0, 4) == "<img" || substr($occurance, 0, 5) == "< img")
			{
				$attributes = explode(" ", htmlentities($occurance));
				foreach ($attributes as $key=>$attribute)
				{
					if($key == 0)
					{
						continue;
					}
					$sub_attribute = substr($attribute, 0, strpos($attribute, "="));
					if (!in_array($sub_attribute, $this->img_values))
					{
						return FALSE;
					}
				}
				return TRUE;
			}
		}
		if (in_array("a", $this->whitelist))
		{
			if (substr($occurance, 0, 2) == "<a" || substr($occurance, 0, 3) == "< a")
			{
				$attributes = explode(" ", htmlentities($occurance));
				foreach ($attributes as $key=>$attribute)
				{
					if($key == 0)
					{
						continue;
					}
					$sub_attribute = substr($attribute, 0, strpos($attribute, "="));
					if (!in_array($sub_attribute, $this->a_values))
					{
						return FALSE;
					}
				}
				return TRUE;
			}
		}
	}

	private function set_attributes_for_img()
	{
		/*
		 * To remove an allowed attribute, comment out using //
		 * To add an allowed attribute, remove // in start of line
		 */
		$this->img_values[] = "alt"; //Search Engines will hate you if you leave this out!
		$this->img_values[] = "height";
		//$this->img_values[] = "longdesc";
		$this->img_values[] = "src"; //Kind of important!
		$this->img_values[] = "width";
	}

	private function set_attributes_for_a()
	{
		/*
		 * To remove an allowed attribute, comment out using //
		 * To add an allowed attribute, remove // in start of line
		 */
		//$this->a_values[] = "download";
		$this->a_values[] = "href"; //Kind of important!
		//$this->a_values[] = "hreflang";
		//$this->a_values[] = "media";
		//$this->a_values[] = "rel";
		$this->a_values[] = "target";
		//$this->a_values[] = "type";
	}
}