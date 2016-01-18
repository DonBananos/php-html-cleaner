<?php
require './html_cleaner.php';

$response = NULL;

if(isset($_POST['submit']))
{
	$whitelist = NULL;
	$cleaner = new Html_cleaner();
	$response = $cleaner->start_cleaning($_POST['text'], $whitelist);
}
?>
<html>
	<head>
		<title>HTML Cleaner - Testing</title>
	</head>
	<body>
		<form action="" method="POST">
			<textarea name="text"></textarea>
			<input type="submit" name="submit">
		</form>
		<hr>
		<?php
		if(!empty($response))
		{
			?>
		<pre><?php echo $response ?></pre>
			<?php
		}
		?>
	</body>
</html>