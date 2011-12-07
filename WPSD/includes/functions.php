<?php 

// shrink_text Function
// This will shorten any string to a specific length, used for Client Name.
function shrink_text($string,$cut_length){
	$cut_after = $cut_length + 3;
	$string = (strlen($string) > $cut_after) ? substr($string,0,$cut_length).'...' : $string;
	return $string;
}

// get_data Function
// This is the function that does the magic and grabs external data from your client's websites.
function get_data($url)
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	$httpheaders = curl_getinfo($ch,CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($httpheaders == "404") { return "noplugin"; } else { return $data; }
}

// Get Current URL
function curPageURL() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
	$pageURL .= "://";
	if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	$pageURL = explode('?',$pageURL);
	$pageURL = $pageURL[0];
	return $pageURL;
}

?>