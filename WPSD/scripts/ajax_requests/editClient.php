<?php

require_once('../../includes/config.php');
require_once('../../includes/mysql.php');

if (isset($_POST['edit']) && $_POST['edit']){
	
	$client_id = $_POST['edit_id'];
	$client_name = $_POST['edit_name'];
	$client_url = $_POST['edit_url'];
	$client_name = addslashes($client_name);

	// Update Client Information
	$sql = "UPDATE
				wpsd_clients
			SET
				client_name = '$client_name',
				client_url = '$client_url'
			WHERE
				client_id = $client_id
			";

	if (!$queryResource = mysql_query($sql)) {
		trigger_error('Query error ' . mysql_error() . ' SQL: ' . $sql);
	}
	
	echo $client_id.','.$client_name.','.$client_url;
	
}

?>