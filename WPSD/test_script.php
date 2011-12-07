<style>
	body { margin:40px; font-family:sans-serif; }
	input { padding:5px; margin:5px 0 0 0; }
</style>

<div style="width:330px; margin:30px auto;">
<h3 style="line-height:25px; text-align:center;">WordPress Status Dashbarod<br />
<small style="font-weight:normal; font-size:15px;">Test Script</small></h3>

<p style="width:330px; font-size:13px; line-height:17px;">
<strong>Step 1:</strong> Choose a client to test the script with. This client must be running WordPress.<br /><br />
<strong>Step 2:</strong> Install the WP Status Dashboard plugin on the client's site. This plugin can be found via search, or by simply downloading it here: <a href="http://wordpress.org/extend/plugins/wp-status-dashboard/">http://wordpress.org/extend/plugins/wp-status-dashboard/</a><br /><br />
<strong>Step 3:</strong> Choose a quick "security code" and enter that on the plugin settings panel found under "Plugins > WP Status Dashboard"<br /><br />
<strong>Step 4:</strong> Enter the information below:<br /><br />
</p><?php

if (isset($_GET['client_url']) && isset($_GET['client_name']) && isset($_GET['security_key'])){
	
	$security_key = $_GET['security_key'];

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
	
	// Get/Setup Variables
	$error = 0;
	$client_url = $_GET['client_url'];
	$client_name = $_GET['client_name'];
	$plugin_updates = 0;
	$data = 0;
	$version = 0;
	
	// What's the most current WordPress version?
	// This will methodically scan the WordPress download page for the version number.
	$cHTML = get_data('http://wordpress.org/download/');
	list( , $cHTML) = explode('latest stable release of WordPress (Version ', $cHTML);
	list($fVersion, ) = explode(')', $cHTML);
	$current_version = trim($fVersion);
	
	if ($security_key){
		$security_check = get_data($client_url.'/wp-content/plugins/wp-status-dashboard/wp_status_dashboard.php?data=security&security_key='.$security_key);
	} else {
		$security_check = true;
	}
	
	if ($security_check){
	
		// Get Status (Indexable or Not Indexable from your client's website.
		$data = get_data($client_url.'/wp-content/plugins/wp-status-dashboard/wp_status_dashboard.php?data=status&security_key='.$security_key);
		
		// Get WP Version from your client's website.
		$version = get_data($client_url.'/wp-content/plugins/wp-status-dashboard/wp_status_dashboard.php?data=version&security_key='.$security_key);
		
		// Get WP Version from your client's website.
		$plugin_updates = get_data($client_url.'/wp-content/plugins/wp-status-dashboard/wp_status_dashboard.php?data=updates&security_key='.$security_key);
		
		// Got nothing? The plugin probably isn't installed.
		if (isset($data) && $data == ''){ $data = 'noplugin'; }
		
		// Clean up strings
		$data = strip_tags($data);
		$version = strip_tags($version);
	
	}
	
	
	
	// ----------------------------------------------------------------------------------
	// Now let's display the client block with this aquired information: 
	
	echo '<div class="block" style="width:300px; padding:0 20px 20px; border:2px solid ';
	
		// Need any other classes for this block? (colors)
		if (!$security_check){
			echo "yellow";
		} else {
			if ($data == "false"){
				echo "red";
			} else if ($data == "true" && $version == $current_version && $plugin_updates == 0){
				if ($data == "true"){
					echo "green";
				} else {
					echo "yellow";
				}
			} else if ($data == 'noplugin'){
				echo "yellow";
			} else {
				echo "white";
			}
		}
		
		echo '">';
		
		// Display the Client Name, text shrunk if needed (full name is still displayed in the title).
		echo '<h2><a target="_blank" href="'.$client_url.'" title="'.$client_name.'">'.shrink_text($client_name,18).'</a></h2>';
		
		// Display the status of the client.
		
		if (!$security_check){
		
			// Not Secure!
			echo "<div class=\"info alert\"><span>Security Key is incorrect!</span></div>";
		
		} else {
		
			// Secure!
			if ($data == "true"){
				// Indexable
				echo "<div class=\"info check\">Status: <span>Indexable</span></div>";
			} else if ($data == "false") {
				// Not Indexable
				echo "<div class=\"info error\">Status: <span>Not Indexable</span></div>";
			} else if ($data == "noplugin") {
				// Plugin not found, or site not loading properly
				echo "<div class=\"info alert\"><span>There was a problem! Maybe the plugin is not installed?</span></div>";
			} else {
				// Error getting any information
				$error = 1; echo "<div class=\"info error\"><span>ERROR</span></div>";
			}
			
			if ($data != "noplugin" && !$error){
			
				$version = (string)$version;
				$current_version = (string)$current_version;
				$version = strip_tags($version);
				$current_version = strip_tags($current_version);
				if ($version == $current_version){
					echo '<div class="info check">WP Version: <span>'.$version.'</span></div>';
				} else {
					echo '<div class="info wp-alert">WP Version: <span><a target="_blank" title="Visit WP Update Panel" href="'.$client_url.'/wp-admin/update-core.php">'.$version.'</a></span></div>';
				}
				
				if ($plugin_updates > 0){
					echo '<div class="info plugin-alert">Plugin Updates: <span><a target="_blank" title="Visit WP Plugin Panel" href="'.$client_url.'/wp-admin/plugins.php">'.$plugin_updates.'</a></span></div>';
				} else {
					echo '<div class="info check">Plugin Updates: <span>0</span></div>';
				}
				
			}
		
		}
		
	echo '</div>';
	
	?><form method="get" action="">
	
		<p><label for="client_name">Enter the Client Name:</label><br />
		<input style="width:320px;" type="text" name="client_name" value="<?php echo $_GET['client_name']; ?>" /></p>
	
		<p><label for="client_name">Enter the Client's URL:</label><br />
		<input style="width:320px;" type="text" name="client_url" value="<?php echo $_GET['client_url']; ?>" /></p>
		
		<p><label for="client_name">Enter the Security Key:</label><br />
		<input style="width:320px;" type="text" name="security_key" value="<?php echo $_GET['security_key']; ?>" /></p>
		
		<p><input type="submit" value="Submit" /></p>
		
	</form><?php

} else {

	?><form method="get" action="">
	
		<p><label for="client_name">Enter the Client Name:</label><br />
		<input style="width:320px;" type="text" name="client_name" value="" /></p>
	
		<p><label for="client_name">Enter the Client's URL:</label><br />
		<input style="width:320px;" type="text" name="client_url" value="http://" /></p>
		
		<p><label for="client_name">Enter the Security Key:</label><br />
		<input style="width:320px;" type="text" name="security_key" value="" /></p>
		
		<p><input type="submit" value="Submit" /></p>
		
	</form><?php

}

?>
</div>