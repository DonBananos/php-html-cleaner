<?php
require './html_cleaner.php';

$response = NULL;

if (isset($_POST['submit']))
{
	$whitelist = NULL;
	$cleaner = new Html_cleaner();
	$response = $cleaner->start_cleaning($_POST['text'], $whitelist);
}
?>
<html>
	<head>
		<title>PHP HTML Cleaner</title>
	</head>
	<body>
		<h1>PHP HTML Cleaner</h1>
		<p>
			Use this file to test your settings for the PHP HTML Cleaner.<br/>
			You can change the allowed attributes and tags in the file <code>/html_cleaner.php</code><br/>
			<br/>
			When using this code for your own, you're able to pass an array of
			whitelisted tags to the start_cleaning method.<br/>
			<br/>
			Please see the license.txt for information about the licensing of
			this software.<br/>
			<br/>
			Regards,<br/>
			Heini Ovason (<a href="https://github.com/heiniovason">Github.com/heiniovason</a>)<br/>
			Mike Jensen (<a href="https://github.com/DonBananos">Github.com/DonBananos</a>)
		</p>
		<form action="" method="POST">
			<textarea name="text" rows="10" cols="50" placeholder="Type a string for testing the PHP HTML Cleaner"></textarea><br/><br/>
			<input type="submit" name="submit">
		</form>
		<?php
		if (!empty($response))
		{
			?>
			<hr>
			<pre>
				<?php echo $response ?>
			</pre>
			<?php
		}
		?>
	</body>
</html>