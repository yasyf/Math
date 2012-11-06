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

<html >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Math</title>
	<meta name="author" content="Yasyf Mohamedali">
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div>
		<em>Arithmetic Series:</em> <br />
		<a href="arithmetic_series_term">[arithmetic series term finder]</a><br />
		<a href="arithmetic_series_sum">[arithmetic sequence sum calculator]</a><br /><br />
		<em>Geometric Series:</em> <br />
		<a href="geometric_series_term">[geometric series term finder]</a><br />
		<a href="geometric_series_sum">[geometric sequence sum calculator]</a><br /><br />
	<em>Infinite Series:</em> <br />
	<a href="infinite_series">[infinite series checker]</a><br />
<a href="infinite_series_sum">[infinite sequence sum calculator]</a><br /><br /><br />
	<em>Miscellaneous:</em> <br />
	<a href="series">[series generator]</a><br />
<a href="sigma_notation">[sigma notation generator]</a><br />
<a href="trophic">[energy through trophic levels calculator]</a><br />
<a href="dilution">[multiple dilutions calculator]</a><br /><br />
© Copyright 2012 Yasyf Mohamedali. All Rights Reserved.<br />
</div>

<p style="font-size:12px;color:#FFFFFF;text-align:center;"><a style="font-size:12px;color:#FFFFFF;" rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Math with PHP Site</span> by <a style="font-size:12px;color:#FFFFFF;" xmlns:cc="http://creativecommons.org/ns#" href="http://www.yasyf.com" property="cc:attributionName" rel="cc:attributionURL">Yasyf Mohamedali </a> is licensed under a <br /> <a style="font-size:12px;color:#FFFFFF;" rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/">Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License</a>.</p>
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