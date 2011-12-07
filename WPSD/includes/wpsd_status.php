<?php
// -----------------------------------------------------------------------------
// LEAVE THIS ALONE - UNLESS YOU WANT TO SCREW UP YOUR UPDATE NOTIFICATIONS ;)
// -----------------------------------------------------------------------------

$wpstatus_url = curPageURL();
$wpstatus_url = explode('index.php',$wpstatus_url);
if (is_array($wpstatus_url)){
	$wpstatus_url = $wpstatus_url[0];
}

// WP Status Dashboard version
$wpsd_version = 1.35;

// Get most recent WP Status Dashboard version
$wpsd_available_version = get_data('http://demos.mindcork.com/wpstatus/product_updates/wpsd_version.txt');

// Get the current WP Status Dashboard Plugin Version
$wpsd_plugin_version = get_data('http://demos.mindcork.com/wpstatus/product_updates/wpsd_plugin_version.txt');

// Are there any messages to display?
$wpsd_messages = get_data('http://demos.mindcork.com/wpstatus/product_updates/messages.txt');
$wpsd_messages = explode('////',$wpsd_messages);
foreach($wpsd_messages as $wpsd_message){
	$wpsd_message = explode('/--/',$wpsd_message);
	foreach($wpsd_message as $key => $message){
		if ($message == $wpsd_version){
			$wpsd_active_message = $wpsd_message[1];
			$wpsd_active_message = explode('//-//',$wpsd_active_message);
			$wpsd_active_message_id = $wpsd_active_message[0];
			$wpsd_active_message = $wpsd_active_message[1];
		}
	}
}

if (!$security_key){
	echo '<div style="text-align:center; margin:100px auto; color:#555; font-size:30px; line-height:34px; width:500px; font-family:sans-serif;">';
	echo 'You need to enter a security key in the "/includes/config.php" file!';
	echo '</div>';
	exit;
}

if (!$dbName || !$dbUser || !$dbPass){
	echo '<div style="text-align:center; margin:100px auto; color:#555; font-size:30px; line-height:34px; width:500px; font-family:sans-serif;">';
	echo 'You need to enter your database information in the "/includes/config.php" file!';
	echo '</div>';
	exit;
}

if (!$admin_user || !$admin_password){
	echo '<div style="text-align:center; margin:100px auto; color:#555; font-size:30px; line-height:34px; width:500px; font-family:sans-serif;">';
	echo 'You need to add username/password information in the "/includes/config.php" file!';
	echo '</div>';
	exit;
}

// Demo mode (only used on the demo site)
// Disables Add, Edit and Delete
$demo_mode = false;
?>