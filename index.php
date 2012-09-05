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
	<link rel="stylesheet" type="text/css" href="http://www.webputty.net/css/agtzfmNzc2ZpZGRsZXIMCxIEUGFnZRj7rRsM" />
	<script type="text/javascript">(function(w,d){if(w.location!=w.parent.location||w.location.search.indexOf('__preview_css__')>-1){var t=d.createElement('script');t.type='text/javascript';t.async=true;t.src='http://www.webputty.net/js/agtzfmNzc2ZpZGRsZXIMCxIEUGFnZRj7rRsM';(d.body||d.documentElement).appendChild(t);}})(window,document);</script>
</head>
<body>
	<div>
		<em>Arithmetic Series:</em> <br />
		<a href="arithmetic%20series%20term%20finder">[arithmetic series term finder]</a><br />
		<a href="arithmetic%20series%20sum%20calculator">[arithmetic sequence sum calculator]</a><br /><br /><br /><br />
		<em>Geometric Series:</em> <br />
		<a href="geometric%20series%20term%20finder">[geometric series term finder]</a><br />
		<a href="geometric%20series%20sum%20calculator">[geometric sequence sum calculator]</a><br /><br /><br /><br />
	<em>Infinite Series:</em> <br />
	<a href="infinite%20series%20checker">[infinite series checker]</a><br />
<a href="infinite%20series%20sum%20calculator">[infinite sequence sum calculator]</a><br /><br /><br /><br /><br />
	<em>Miscellaneous:</em> <br />
	<a href="series%20generator">[series generator]</a><br />
<a href="sigma%20notation%20generator">[sigma notation generator]</a><br /><br /><br /><br /><br />
© Copyright 2011 Yasyf Mohamedali. All Rights Reserved.<br />
</div>

<p style="font-size:12px;color:#FFFFFF;text-align:center;"><a style="font-size:12px;color:#FFFFFF;" rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Pre-Calculus 11 Site</span> by <a style="font-size:12px;color:#FFFFFF;" xmlns:cc="http://creativecommons.org/ns#" href="http://www.yasyf.com" property="cc:attributionName" rel="cc:attributionURL">Yasyf Mohamedali </a> is licensed under a <br /> <a style="font-size:12px;color:#FFFFFF;" rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/">Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License</a>.</p>
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