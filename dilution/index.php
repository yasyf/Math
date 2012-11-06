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
					initial concentration = <input type="text" name="Ci" value="<?php echo $_GET['Ci']; ?>" /> <br />
					liters carried forward = <input type="text" name="Lf" value="<?php echo $_GET['Lf']; ?>" /> <br />
					liters diluted to = <input type="text" name="Ld" value="<?php echo $_GET['Ld']; ?>" /> <br />
					number of dilutions = <input type="text" name="n" value="<?php echo $_GET['n']; ?>" /> <br />
					<input type="submit" value="Submit" />
					</form>
	<?php
	error_reporting(0);
	if (isset($_GET['Ci']) && isset($_GET['Lf']) && isset($_GET['Ld'])  && isset($_GET['n']))

	{
	if (is_numeric($_GET['Ci']) && is_numeric($_GET['Lf']) && is_numeric($_GET['Ld']) && is_numeric($_GET['n']))	

	{
		$Ci = $_GET['Ci'];
		$Lf = $_GET['Lf'];
		$Ld = $_GET['Ld'];
		$n = $_GET['n'];
	for ($i=0;$i<$n;$i++) {
		$tt = $i+1;
		$moles = $Ci*$Lf;
		$conc = $moles / $Ld;
		$Ci = $conc;
		echo "Test Tube $tt: $conc M <br />";
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