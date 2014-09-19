<?php // - publicmeeting.php
//Public Meeting page for app. It uses templates to create the layout.
session_start();

//Include the header base on whether a user is already logged in:
if (isset($_SESSION['email']) && ($_SESSION['agent']) && ($_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']))) {
	
	$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		
	if($host == 'khlogic.org/publicmeeting.php') {
		require('include/functions.inc.php');
		include('include/header.html'); // "content" div opens in header and closes in footer
		include('include/week_of.php'); //contains 
		include('include/schedule.php'); // the schedule function in the "main" div
		include('include/footer.html');//Include the footer
	} // END conditional check for URL.

} else {
include('include/login_header.html');
}
		/*
		echo '<div id="sidebar" class="">';
		$select_detail = '<select name="monday" id="monday" onchange="this.form.submit()">';
		$select_title = 'Week of Monday...';
		week_of($select_detail, $select_title); //Function in include/config.inc.php
		echo '</div>';
		
		echo '<div id="main" class="">';
		$schedule = schedule();
		echo $schedule;	
		echo '</div>';
		*/
?>