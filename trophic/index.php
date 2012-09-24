<?php
// TOP of your script
$cachefile = 'cache/'.'index';
if ($_SERVER['QUERY_STRING']!='') {
$cachefile .= '_'.base64_encode($_SERVER['QUERY_STRING']);
}
// Serve from the cache 

if (file_exists($cachefile)) {

include($cachefile);

exit;

}
ob_start(); // start the output buffer
// Your normal PHP script and HTML content here
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style.css" />
	</head>
	<body>
			<div>
				<form action="" method="get">
					# of trophic levels = <input type="text" name="n" value="<?php echo $_GET['a']; ?>" /> <br />
					% energy preserved per level = <input type="text" name="p" value="<?php echo $_GET['n']; ?>" /> <br />
					initial energy present = <input type="text" name="i" value="<?php echo $_GET['d']; ?>" /> <br />
					<input type="submit" value="Submit" />
					</form>
	<?php
	error_reporting(0);
	if (isset($_GET['n']) && isset($_GET['p']) && isset($_GET['i']))

	{
	if (is_numeric($_GET['n']) && is_numeric($_GET['p']) && is_numeric($_GET['i']))	

	{
		$n = $_GET['n'];
		$p = $_GET['p'];
		$i = $_GET['i'];
		
		$preseved = $p/100;
		$base = $i;
		for ($x=1;$x<=$n;$x++) {
		$present = round($base * pow($preseved,$x),3);
		$lost = round($base - $present,3);
		echo("<b>Level: $x</b> <br /> Present: $present <br /> Lost: $lost <br /> <br />");
		}
	}
	else {
		echo "Values For 'n', 'p', and 'i' Must Be Integers!";
	}
	}
	else {
		echo "Values For 'n', 'p', and 'i' Must Be Entered!";
	}
	?>
	</div>
	</body>
</html>

<?php
// BOTTOM of your script
$fp = fopen($cachefile, 'w'); // open the cache file for writing
fwrite($fp, ob_get_contents()); // save the contents of output buffer to the file
fclose($fp); // close the file
ob_end_flush(); // Send the output to the browser

?>