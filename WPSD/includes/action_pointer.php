<?php

// Signing in?
if (isset($_POST['action']) && $_POST['action'] == 'signin'){

	$signin_username = $_POST['username'];
	$signin_password = $_POST['password'];
	if (strtolower($signin_username) == strtolower($admin_user) && $signin_password == $admin_password){
		$_SESSION['$signed_in'] = 1;
		$_SESSION['$signed_in_user'] = $admin_user;
	} else {
		$signin_error = 1;
	}
		
}

?>