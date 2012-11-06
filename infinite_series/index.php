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
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../style.css" />
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
<br /><br /><br /><br /><span id="short"></span>
	</div>
	<script type="text/javascript">
	function showHide(ID) {
			elem = document.getElementById(ID);
			if (elem.style.display == 'none') {
				elem.style.display = 'block';
			}
			else{
				elem.style.display = 'none';
			}
		}
		
		 $.getJSON(
		        "http://api.bitly.com/v3/shorten?callback=?", 
		        { 
		            "format": "json",
		            "apiKey": "R_a551579385b3fb84f6796876d396659b",
		            "login": "yasyf",
		            "longUrl": window.location.href
		        },
		        function(response)
		        {
		document.getElementById("short").innerHTML =  "Link to this page: <a href='"+response.data.url+"'>"+response.data.url+"</a>";
		}
		    );


	</script>
</body>
</html>
<?php
// BOTTOM of your script
$fp = fopen($cachefile, 'w'); // open the cache file for writing
fwrite($fp, ob_get_contents()); // save the contents of output buffer to the file
fclose($fp); // close the file
ob_end_flush(); // Send the output to the browser

?>