<?php // - index.php - Home page for app. It uses templates to create the layout.
session_start();
if (isset($_SESSION['email']) && ($_SESSION['agent']) && ($_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']))) { 	//If the user is logged in, show site, if not, show logon page
	$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	if((strpos($host, 'khlogic.org/index.php') !== false)) {
		include('include/header.html');																					// "content" div opens in header and closes in footer
		require('include/functions.inc.php');
		require('include/functions_date.php');
		require('model/data_functions.php');
		include('include/week_of.php');																					//contains 
		include('include/schedule.php');																				// the schedule function in the "main" div
		include('include/footer.html');																					//Include the footer
	}
} else {																												// END conditional check for URL
	include('include/login_header.html');
}
?>