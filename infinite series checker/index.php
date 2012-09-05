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
	<link rel="stylesheet" type="text/css" href="http://www.webputty.net/css/agtzfmNzc2ZpZGRsZXIMCxIEUGFnZRj7rRsM" />
	<script type="text/javascript">(function(w,d){if(w.location!=w.parent.location||w.location.search.indexOf('__preview_css__')>-1){var t=d.createElement('script');t.type='text/javascript';t.async=true;t.src='http://www.webputty.net/js/agtzfmNzc2ZpZGRsZXIMCxIEUGFnZRj7rRsM';(d.body||d.documentElement).appendChild(t);}})(window,document);</script>
	</head>
	<body>
		<div>
			<form action="" method="get">
				r = <input type="text" name="r" value="<?php echo $_GET['r']; ?>" /> <br />
				<input type="submit" value="Submit" />
				</form>
<?php
error_reporting(0);
if (isset($_GET['r']))
{
if(is_numeric($_GET['r']))
{
	$r = ($_GET['r']);
	
if ($r >= 1 || $r <= -1)
{
	if ($r > 1)
	{
		echo "Series is Divergent (Increasing)";
		
	}
	else if ($r < -1)
	{
		
		echo "Series is Divergent (Decreasing)";
		
	}
	else
	{
	echo "Series is Divergent";
}
}
else
{
	
	echo "Series is Convergent";
}
}
else {
	echo "Value For 'r' Must Be An Integer!";
}
}
else {
	echo "Value For 'r' Must Be Entered!";
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