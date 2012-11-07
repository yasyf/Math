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
					initial concentration = <input type="text" name="Ci" value="<?php echo $_GET['Ci']; ?>" /> <br />
					liters of solution carried forward = <input type="text" name="Lf1" value="<?php echo $_GET['Lf1']; ?>" /> <br />
					liters diluted to = <input type="text" name="Ld1" value="<?php echo $_GET['Ld1']; ?>" /> <br />
					<span onclick="showHide('s2');">(optional) step 2:</span><br />
					<span style="display: none;" id="s2">liters of solution carried forward = <input type="text" name="Lf2" value="<?php echo $_GET['Lf2']; ?>" /> <br />				liters diluted to = <input type="text" name="Ld2" value="<?php echo $_GET['Ld2']; ?>" /> <br /></span>
					<br />
					number of dilutions = <input type="text" name="n" value="<?php echo $_GET['n']; ?>" /> <br />
					<input type="submit" value="Submit" />
					</form>
	<?php
	error_reporting(0);
	if (isset($_GET['Ci']) && isset($_GET['Lf1']) && isset($_GET['Ld1']) && isset($_GET['n']))

	{
	if (is_numeric($_GET['Ci']) && is_numeric($_GET['Lf1']) && is_numeric($_GET['Ld1']) && is_numeric($_GET['n']))	

	{
		$Ci = $_GET['Ci'];
		$Lf1 = $_GET['Lf1'];
		$Ld1 = $_GET['Ld1'];
		$Lf2 = $_GET['Lf2'];
		$Ld2 = $_GET['Ld2'];
		$Lf3 = $_GET['Lf3'];
		$Ld3 = $_GET['Ld3'];
		$n = $_GET['n'];
		$Ci2 = dilute($Ci,$Lf2,$Ld2);
	for ($i=0;$i<=$n;$i++) {
			$tt = $i+1;
			if($i>0)
			{
			$Ci = dilute($Ci,$Lf1,$Ld1);
			if(isset($_GET['Lf2']) && isset($_GET['Ld2']) && is_numeric($_GET['Lf2']) && is_numeric($_GET['Ld2']))
			{
			$Ci2 = dilute($Ci,$Lf2,$Ld2);
				}
			}
			echo "Test Tube $tt: $Ci2 M <br />";
	}
	
		}
	else {
		echo "Values Must Be Integers!";
	}
	}
	else {
		echo "Shown Values Must Be Entered!";
	}
	function dilute($Ci,$Lf,$Ld) {
				$moles = $Ci*$Lf;
				$conc = $moles / $Ld;	
				return $conc;
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