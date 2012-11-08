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
					# of trophic levels = <input type="text" name="n" value="<?php echo $_GET['n']; ?>" /> <br />
					% energy preserved per level = <input type="text" name="p" value="<?php echo $_GET['n']; ?>" /> <br />
					initial energy present = <input type="text" name="i" value="<?php echo $_GET['i']; ?>" /> <br />
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
		$total = 0;
		for ($x=0;$x<$n;$x++) {
			if($x===0)
			{
				$presentPrevious = $base * pow($preseved,$x);
			}
		else {
			$presentPrevious = $base * pow($preseved,$x-1);
		}
		$present = $base * pow($preseved,$x);
		$lost = $presentPrevious - $present;
		$total = $total + $present;
		$present = round($present,3);
		$lost = round($lost,3);
		$level = $x+1;
		echo("<b>Level: $level</b> <br /> Present: $present <br /> Lost: $lost <br /> <br />");
		}
		$total = round($total,3);
		echo("<b>Total Energy: $total");
	}
	else {
		echo "Values For 'n', 'p', and 'i' Must Be Integers!";
	}
	}
	else {
		echo "Values For 'n', 'p', and 'i' Must Be Entered!";
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