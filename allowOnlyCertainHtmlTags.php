<?php
$whitelist = array("p", "b", "ul", "li", "u", "a", "ol", "img", "i", "br",
					"/p", "/b", "/ul", "/li", "/u", "/a", "/ol", "/img", "/i", "br/", "br /"
					); 
$input = "<img=\"/blabla.jpg /><img='/blabla.jpg /><a=\"http://dajuwh/diadh/aedew.php></a><a='http://dajuwh/diadh/aedew.php></a><b></b><ul>Erkan</ul><script>alert('argh!!!');</script><script>alert('argh!!!');</script>";
/*
	OBS! Need to be able to hande <someWhiteListTag> + ="jadadadad
*/
for($i=0; $i<=strlen($input); $i++)
{
	echo "Index: $i<br>";	
	/* Does the index contain the string "<" ? */
	if($input[$i]==="<")
	{
		/*
			Cool then find the preceeding index(returns an int) 
			of the next occurence of '>'.
			stripos(Input String, Next occurence of substring, Start index)
		*/
		$nextOpenTagPos = stripos($input, "<", $i);
		$nextCloseTagPos = stripos($input, ">", $i);
		/* Let's jump ahead to current > in next iteration to save computation */
		$i = $nextCloseTagPos;
		$len = $nextCloseTagPos - $nextOpenTagPos;
		/* Testing variables for index positions of '<' and '>' */
		echo "Index to begin search from: $i<br>";
		echo "Index of next '<': $nextOpenTagPos<br>";	
		echo "Index of next '>': $nextCloseTagPos<br>";	
		/*
			Find the substring between < and >
			param 1: input string
			param 2: Begin index
			param 3: length
		*/
		$subStrBetweenTags = substr($input, $nextOpenTagPos+1, $len-1);	
		/* Testing value between '<' and '>'.*/
		echo "<b>Substring between tags: $subStrBetweenTags</b><br>";

		/* NOT OPTIMAL - CONSIDER MAKING REGEX ON WHITELISTTAG+MUMJUMBO */
		if(strpos($subStrBetweenTags, "img=\"") !== FALSE || strpos($subStrBetweenTags, "img='") !== FALSE)
		{
			continue;
		}
		else if(strpos($subStrBetweenTags, "a=\"") !== FALSE || strpos($subStrBetweenTags, "a='") !== FALSE)
		{
			continue;
		}	
		else
		{
			/* If value between < and > is not in $whitelist, then screw you */
			if(in_array($subStrBetweenTags, $whitelist) !== TRUE)
			{
			die("<h3 style='color:red;'>Prohibited value between tags: <u>$subStrBetweenTags</u></h3><br>");

			}
		}	
	}
}
?>