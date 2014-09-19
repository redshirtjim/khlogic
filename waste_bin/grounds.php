<?php // - grounds.php
//Ground Keeping page for app. It uses templates to create the layout.
session_start();

//Include the header base on whether a user is already logged in:
if (isset($_SESSION['email']) && ($_SESSION['agent']) && ($_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']))) {
	
	$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		
	if($host == 'khlogic.org/grounds.php') {
		require('include/functions.inc.php');
		include('include/header.html'); // "content" div opens in header and closes in footer
		include('include/week_of.php'); //contains 
		include('include/schedule.php'); // the schedule function in the "main" div
		include('include/footer.html');//Include the footer
	} // END conditional check for URL.

} else {
include('include/login_header.html');
}
?>