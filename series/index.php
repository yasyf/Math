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
			<script type="text/javascript" id="WolframAlphaScript739465804a0e17d2a47c9bc9c805d60a" src="http://www.wolframalpha.com/widget/widget.jsp?id=739465804a0e17d2a47c9bc9c805d60a&amp;theme=green&amp;output=iframe&amp;width=600&amp;height=500"></script>
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