<?php // - edit_details.php
//Admin page used to add, edit, and delete publishers.
session_start();
include ('include/header.html');
require ('model/data_functions.php');
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$page = $_SERVER['REQUEST_URI'];																		// Assign current URL to a variable to use in the form action. This will include the GET date for the week of Monday...
$nav_href = 'edit_details.php?monday=';																	// For use in week_nav()
$admin_auth =& admin_auth($user_id, $email);															// *** First, check if user has permission to view the page ***
if ($admin_auth == 0) {
	require ('include/login_functions.inc.php');
	redirect_user('index.php');
} else { 																								// *** END permission check ***
	require ('include/functions.inc.php');
	require ('include/functions_date.php');
	require (MYSQL);
	$monday = $_GET['monday']; 																			// Date value from URL. Always represents the date of a Monday of the week.
	$date = date('F j, Y', strtotime($monday));
	$sunday = date('F j, Y', strtotime('+6 days', strtotime($monday)));
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {															// Handle the form.
		$problem = FALSE;
		$song_1 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['song_1'])));
		$cbs = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['cbs'])));
		$cbs_url = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['cbs_url'])));
		$bible_read = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['bible_read'])));
		$no_1 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['no_1'])));
		$no_2 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['no_2'])));
		$no_2_source = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['no_2_source'])));
		$no_2_url = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['no_2_url'])));
		$no_3 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['no_3'])));
		$no_3_source = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['no_3_source'])));
		$no_3_url = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['no_3_url'])));
		$song_2 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['song_2'])));
		$sm_1 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['sm_1'])));
		$sm_2 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['sm_2'])));
		$sm_3 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['sm_3'])));
		$song_3 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['song_3'])));
		$ptws_song_1 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['ptws_song_1'])));
		$ptws_song_2 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['ptws_song_2'])));
		$wt_study = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['wt_study'])));
		$ptws_song_3 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['ptws_song_3'])));
		$details_msg =& write_details($monday, $song_1, $cbs, $cbs_url, $bible_read, $no_1, $no_2, $no_2_source, $no_2_url, $no_3, $no_3_source, $no_3_url, $song_2, $sm_1, $sm_2, $sm_3, $song_3, $ptws_song_1, $ptws_song_2, $wt_study, $ptws_song_3);
	}
	$ptws_query = "SELECT *
	FROM ptws_detail
	WHERE week_of = '$monday'";
	$ptws_r = mysqli_query ($dbc, $ptws_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nptws_query: $ptws_query");
	while ($ptws_row = mysqli_fetch_array($ptws_r)) {
		$ptws_song_1 = $ptws_row['ptws_song_1'];
		$ptws_song_2 = $ptws_row['ptws_song_2'];
		$wt_study = $ptws_row['wt_study'];
		$ptws_song_3 = $ptws_row['ptws_song_3'];
	}
	$cts_detail_query = "SELECT * FROM cts_detail WHERE week_of = '$monday'";
	$cts_r = mysqli_query ($dbc, $cts_detail_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\ncts_query: $cts_detail_query");
	while ($cts_row = mysqli_fetch_array($cts_r)) {
		$song_1 = $cts_row['song_1'];
		$cbs = $cts_row['cbs'];
		$cbs_url = $cts_row['cbs_url'];
		$bible_read = $cts_row['bible_read'];
		$no_1 = $cts_row['no_1'];
		$no_2 = $cts_row['no_2'];
		$no_2_source = $cts_row['no_2_source'];
		$no_2_url = $cts_row['no_2_url'];
		$no_3 = $cts_row['no_3'];
		$no_3_source = $cts_row['no_3_source'];
		$no_3_url = $cts_row['no_3_url'];
		$song_2 = $cts_row['song_2'];
		$sm_1 = $cts_row['sm_1'];
		$sm_2 = $cts_row['sm_2'];
		$sm_3 = $cts_row['sm_3'];
		$song_3 = $cts_row['song_3'];
	}
	require (CLSMYSQL);																		// Close the connection
	include ('view/form_edit_details.html');
	week_nav ($nav_href, $monday, $prevw, $currw, $nextw);									// Week to week navigation	
	include ('include/footer.html');															//Include the footer
}																							// End of form submission IF
?>