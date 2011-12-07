<?php session_start();

// Setup the WP Status Dashboard
include('includes/config.php');
include('includes/mysql.php');

// Trying to sign out?
if (isset($_GET['signout']) && $_GET['signout']){
	$signedout = 1;
	session_destroy();
}

// Action to be made? (signin/add/edit/delete)
if (isset($_POST['action']) && $_POST['action']){
	include('includes/action_pointer.php');
}

// Are you signed in?
if (!isset($signedout) && isset($_SESSION['$signed_in']) && $_SESSION['$signed_in']){

	// Yep, display the dashboard!
	include('includes/dashboard.php');

} else {

	// Nope, not signed in!
	include('includes/signin.php');

} ?>