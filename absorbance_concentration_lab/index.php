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
	<script type="text/javascript">
						function updateFields(){
						$('#fields').html("");
						for (var i=2;i<=document.getElementById('n').value;i++)
						{ 
						$('#fields').append("absorbance of tube "+i+" = <input type='text' name='Ax"+i+"' /> <br />");
						}
						
					}
						</script>
			<div>
				<form action="" method="get">
					number of test tubes = <input type="text" name="n" id="n" value="<?php echo $_GET['n']; ?>" onblur="updateFields();" /> <br />
					Intial Concentrations:<br />
					initial concentration Fe<sup>3+</sup> source = <input type="text" name="CiFe" value="<?php echo $_GET['CiFe']; ?>" /> <br />
					initial concentration SCN<sup>-</sup> source = <input type="text" name="CiSCN" value="<?php echo $_GET['CiSCN']; ?>" /> <br />
					Serial Dilution:<br />
					liters of Fe<sup>3+</sup> solution carried forward = <input type="text" name="Lf1Fe" value="<?php echo $_GET['Lf1Fe']; ?>" /> <br />
					liters Fe<sup>3+</sup> solution diluted to = <input type="text" name="Ld1Fe" value="<?php echo $_GET['Ld1Fe']; ?>" /> <br />
					Reaction Dilution:<br />
					liters of Fe<sup>3+</sup> solution = <input type="text" name="Lf2Fe" value="<?php echo $_GET['Lf2Fe']; ?>" /> <br />					liters of SCN<sup>-</sup> solution = <input type="text" name="Lf2SCN" value="<?php echo $_GET['Lf2SCN']; ?>" /> <br />
					<br />
					
					Absorbance Concentrations:<br />
					absorbance of tube 1 = <input type="text" name="Ai"  value="<?php echo $_GET['Ai']; ?>" /> <br />
				
					<div id="fields">
					<?php
					for ($i=2;$i<$_GET['n'];$i++) { 
					extract($_GET, EXTR_SKIP);
					$var = "Ax$i";
					$Ax = $$var;
					echo "absorbance of tube $i = <input type='text' name='Ax$i' value='$Ax' /><br />";
					}
					?>
					</div>
					<input type="submit" value="Submit" />
					</form>
					<center>
					<table border=1>
					  <tbody>
					    <!-- Results table headers -->
					    <tr>
						<th>Tube</th>
						<th>[Fe<sup>3+</sup>]<sub>i</sub></th>
					      <th>[SCN<sup>-</sup>]<sub>i</sub></th>
					      <th>Absorbance</th>
					      <th>[FeSCN<sup>2+</sup>]<sub>eq</sub></th>
					    </tr>
	<?php
	//error_reporting(0);
			if (isset($_GET['n']) && is_numeric($_GET['n']))
			{
		extract($_GET, EXTR_SKIP);
		$LdRxn = $Lf2Fe + $Lf2SCN;
		$Ax = "Ai";
		$Ci2Fe = dilute($CiFe,$Lf2Fe,$LdRxn);
		$CSCN = dilute($CiSCN,$Lf2SCN,$LdRxn);
		$CiFeSCN = $CSCN;
		$rxnConcFe = array();
		$rxnConcSCN = array();
		$absorbance = array();
		$eqConcFeSCN = array();
			for ($i=0;$i<$n;$i++) {
				$tt = $i+1;
			echo("<tr id='tt $tt'>");
			if($i>0)
			{
			$CiFe = dilute($CiFe,$Lf1Fe,$Ld1Fe);
			$Ci2Fe = dilute($CiFe,$Lf2Fe,$LdRxn);
			$CSCN = dilute($CiSCN,$Lf2SCN,$LdRxn);
			$Ax = "Ax$tt";
			$CiFeSCN = absorbance_conc($CiFeSCN,$$Ax,$Ai);
			}
			$rxnConcFe[$i] = $Ci2Fe;
			$rxnConcSCN[$i] = $CSCN;
			$absorbance[$i] = $$Ax;
			$eqConcFeSCN[$i] = $CiFeSCN;
			echo "<td id='$tt c1'>$tt</td>";
			echo "<td id='$tt c2'>$rxnConcFe[$i]</td>";
			echo "<td id='$tt c3'>$rxnConcSCN[$i]</td>";
			echo "<td id='$tt c4'>$absorbance[$i]</td>";
			echo "<td id='$tt c5'>$eqConcFeSCN[$i]</td>";
			echo(" 
			   	  </tr>");
	}
			}


	function dilute($Ci,$Lf,$Ld) {
				$moles = $Ci*$Lf;
				$conc = $moles / $Ld;	
				return $conc;
	}
	function absorbance_conc($CFeSCN,$Ax,$Ai) {
			$CeqFeSCN = $CFeSCN * ($Ax/$Ai);
			return $CeqFeSCN;
	}

	?>
	  </tbody>
	</table>
	</center>
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