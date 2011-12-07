<?php

include('includes/config.php');

// Get/Setup Variables
$error = 0;
$client_id = $_GET['client_id'];
$id = $client_id;
$client_url = $_GET['client_url'];
$client_name = $_GET['client_name'];
$width = $_GET['width'];
$plugin_updates = 0;
$data = 0;
$version = 0;

// Get required jQuery Actions
include('includes/get_data_js.php');

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

echo '<div id="client-block-'.$client_id.'" class="block';

	// Need any other classes for this block? (colors)
	if (!$security_check){
		echo " yellow";
	} else {
		if ($data == "false"){
			echo " red";
		} else if ($data == "true" && $version == $current_version && $plugin_updates == 0){
			if ($data == "true"){
				echo " green";
			} else {
				echo " yellow";
			}
		} else if ($data == 'noplugin'){
			echo " yellow";
		}
	}
	
	// End it with the proper width.
	echo '" style="width:'.$width.'px;">';
	
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
	
	echo '<div class="left-icons">';
		echo '<a id="refresh-'.$id.'" title="Refresh Client" class="icon refresh">Refresh</a>';
	echo '</div>';
	echo '<div class="right-icons">';
		if ($security_check){ echo '<a href="'.$client_url.'/wp-admin/" title="Visit WP Admin" target="_blank" class="icon admin">WP Admin</a>'; }
		echo '<a id="edit-'.$id.'" title="Edit Client" class="icon edit">Edit</a>';
		echo '<a id="delete-'.$id.'" title="Delete Client" class="icon delete">Delete</a>';
	echo '</div>';
	
echo '</div>';

?>