<?php
// TOP of your script
$cachefile = 'cache/'.'index';
if ($_SERVER['QUERY_STRING']!='') {
$cachefile .= '_'.base64_encode($_SERVER['QUERY_STRING']);
}
// Serve from the cache 

if (file_exists($cachefile)) {

if($_REQUEST['print'] == "yes")
	{
			require_once("../PDF/mpdf.php");
			$mpdf=new mPDF();
			$mpdf->WriteHTML(file_get_contents($cachefile));
			$mpdf->Output();
			exit();

	}
	else {
		include($cachefile);
		exit();
	}


}
ob_start(); // start the output buffer
// Your normal PHP script and HTML content here
$title = "Analyzing Quantitative Relationships Involving Concentrations of Reactants and Products at Equilibrium";
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
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
					Number Of Test Tubes = <input type="text" name="n" id="n" value="<?php echo $_GET['n']; ?>" onblur="updateFields();" /> <br />
					Intial Concentrations:<br />
					Initial Concentration Fe<sup>3+</sup> Source = <input type="text" name="CiFe" value="<?php echo $_GET['CiFe']; ?>" /> <br />
					initial concentration SCN<sup>-</sup> Source = <input type="text" name="CiSCN" value="<?php echo $_GET['CiSCN']; ?>" /> <br />
					Serial Dilution:<br />
					Liters Of Fe<sup>3+</sup> Solution Carried Forward = <input type="text" name="Lf1Fe" value="<?php echo $_GET['Lf1Fe']; ?>" /> <br />
					Liters Fe<sup>3+</sup> Solution Diluted To = <input type="text" name="Ld1Fe" value="<?php echo $_GET['Ld1Fe']; ?>" /> <br />
					Reaction Dilution:<br />
					Liters Of Fe<sup>3+</sup> Solution = <input type="text" name="Lf2Fe" value="<?php echo $_GET['Lf2Fe']; ?>" /> <br />					Liters Of SCN<sup>-</sup> Solution = <input type="text" name="Lf2SCN" value="<?php echo $_GET['Lf2SCN']; ?>" /> <br />
					<br />
					
					Absorbance Concentrations:<br />
					&nbsp;Absorbance Of Tube 1 = <input type="text" name="Ai"  value="<?php echo $_GET['Ai']; ?>" /> <br />
				
					<div id="fields">
					<?php
					for ($i=2;$i<=$_GET['n'];$i++) { 
					extract($_GET, EXTR_SKIP);
					$var = "Ax$i";
					$Ax = $$var;
					echo "Absorbance Of Tube $i = <input type='text' name='Ax$i' value='$Ax' /><br />";
					}
					?>
					</div>
					<input type="submit" value="Submit" />
					</form>
					<center>
					<br />Data<br />
					<table border=1>
					  <tbody>
					    <!-- Results table headers -->
					    <tr>
						<th>Tube</th>
						<th>[Fe<sup>3+</sup>]<sub>i</sub></th>
					      <th>[SCN<sup>-</sup>]<sub>i</sub></th>
						<th>[FeSCN<sup>2+</sup>]<sub>i</sub></th>
					      <th>Absorbance</th>
						<th>[Fe<sup>3+</sup>]<sub>eq</sub></th>
						<th>[SCN<sup>-</sup>]<sub>eq</sub></th>
					     <th>[FeSCN<sup>2+</sup>]<sub>eq</sub></th>

					    </tr>
	<?php
	error_reporting(0);
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
		$eqConcFe = array();
		$eqConcSCN = array();
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
			$eqConcFe[$i] = eqConc($rxnConcFe[$i],$eqConcFeSCN[$i]);
			$eqConcSCN[$i] = eqConc($rxnConcSCN[$i],$eqConcFeSCN[$i]);
			echo "<td id='$tt tt'>$tt</td>";
			echo "<td id='$tt CiFe'>$rxnConcFe[$i]</td>";
			echo "<td id='$tt CiSCN'>$rxnConcSCN[$i]</td>";
			echo "<td id='$tt CiFeSCN'>0</td>";
			echo "<td id='$tt abs'>$absorbance[$i]</td>";
			echo "<td id='$tt CeqFe'>$eqConcFe[$i]</td>";
			//dirty fix
			if($i==1)
			{
				echo "<td id='$tt CeqSCN'>";
				echo number_format($eqConcSCN[$i],15);
				echo "</td>";
			}
			else {
				echo "<td id='$tt CeqSCN'>$eqConcSCN[$i]</td>";
			}
			echo "<td id='$tt CeqFeSCN'>$eqConcFeSCN[$i]</td>";
			echo("</tr>");
	}
			}
			?>
			  </tbody>
				</table>
				<br />K<sub>eq</sub> Trials<br />
				<table border=1>
									  <tbody>
									    <!-- Results table headers -->
									    <tr>
										<th>Tube</th>
										<th>K<sub>eq</sub> A</th>
										<th>K<sub>eq</sub> B<a href="#note">*</a></th>
										<th>K<sub>eq</sub> C</th>
										<th>K<sub>eq</sub> D</th>
										</tr>			<?php
			if (isset($_GET['n']) && is_numeric($_GET['n']))
						{
			$A = array();
			$B = array();
			$C = array();
			$D = array();
			for ($i=1;$i<$n;$i++) {
							$tt = $i+1;
						echo("<tr id='trial $tt'>");
						$A[$i] = ($eqConcFeSCN[$i]*$eqConcFe[$i])/$eqConcSCN[$i];
						$B[$i] = $eqConcFeSCN[$i]/($eqConcFe[$i]*$eqConcSCN[$i]);
						$C[$i] = $eqConcSCN[$i]*$eqConcFeSCN[$i]*$eqConcFe[$i];
						$D[$i] = ($eqConcFe[$i] + $eqConcSCN[$i]) / $eqConcFeSCN[$i];
						echo "<td id='$tt tube'>$tt</td>";
						echo "<td id='$tt A'>$A[$i]</td>";
						echo "<td id='$tt B'>$B[$i]</td>";
						echo "<td id='$tt C'>$C[$i]</td>";
						echo "<td id='$tt D'>$D[$i]</td>";
						echo("</tr>");
						}
						echo "<tr><td></td></tr>";
						$ratio = array();
						$ratio['A'] = ratio($A);
						$ratio['B'] = ratio($B);
						$ratio['C'] = ratio($C);
						$ratio['D'] = ratio($D);
						echo("<tr id='trial totals'>");
						echo "<td id='total tube'>Deviation Ratio</td>";
						echo "<td id='total A'>".$ratio["A"]."</td>";
						echo "<td id='total B'>".$ratio["B"]."</td>";
						echo "<td id='total C'>".$ratio["C"]."</td>";
						echo "<td id='total D'>".$ratio["D"]."</td>";
						echo("</tr>");
						
						$ratioAbs = array();
						foreach ($ratio as $key => $value) {
							$value = abs($value - 1);
							$ratioAbs["$key"] = $value;
						}
						$validKeq = array_search(min($ratioAbs),$ratioAbs);
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
	function eqConc($CiReact,$CeqProd) {
			$CeqReact = $CiReact - $CeqProd;
			return $CeqReact;
	}
	function ratio($array) {

		$mean = $sum / count($array);
		$ratio = max($array) / min($array);
		return $ratio;
	}
	/* returns the shortened url */
	function get_bitly_short_url($url,$login,$appkey,$format='txt') {
	  $connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
	  return curl_get_result($connectURL);
	}

	/* returns a result form url */
	function curl_get_result($url) {
	  $ch = curl_init();
	  $timeout = 5;
	  curl_setopt($ch,CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}
	
	$Url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if($_REQUEST['print'] == "yes")
		{
		$Url = substr($Url, 0, -10);
		}
	$PDFUrl = $Url."&print=yes";
	$short_url = get_bitly_short_url($Url,'yasyf','R_a551579385b3fb84f6796876d396659b');
	?>
	  </tbody>
	</table>
	<a id="note"></a>
	<span style="font-size:12px">*Previously known to be the actual calculation for K<sub>eq</sub></span>
	<br />
	<p><?php echo "Result: K<sub>eq</sub> Trial <strong>$validKeq</strong> is the correct equilibrium expression calculation."; ?><p>
	</center>
	<div style="font-size:16px" class="smaller">
	<p style="font-size:16px" class="smaller"><a style="font-size:16px" class="smaller" href="<?php echo $PDFUrl ?>">Generate Downloadable PDF</a></p>
	<p style="font-size:16px" class="smaller"><a style="font-size:16px" class="smaller" href="#" onclick="window.print();return false;">Print This Page</a></p>
	<p id="short" style="font-size:16px">Link to this page: <a style='font-size:16px' href="<?php echo $short_url; ?>"><?php echo $short_url; ?></a></p>
	</div>
	</div>

	</body>
</html>

<?php
		$html = ob_get_contents();
		$fp = fopen($cachefile, 'w'); // open the cache file for writing
		fwrite($fp, $html); // save the contents of output buffer to the file
		fclose($fp); // close the file
		chmod($cachefile,0755);
	if($_REQUEST['print'] == "yes")
	{
			ob_end_clean();
			require_once("../PDF/mpdf.php");
			$mpdf=new mPDF();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit();
	}
	else {
		// BOTTOM of your script
		ob_end_flush(); // Send the output to the browser
		exit();
		}




?>