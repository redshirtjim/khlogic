<?php // - edit_servicemeeting.php
/*Allows a scheduler to assign parts/tasks.
1. Check if user has permission to view the page
2. Display a select/option form for each assignment based on data from the assignments table
3. Each form is submitted when the selection is changed
4. When a form is submitted with a set user id in the POST, then a record in the assignments table is either inserted or updated.*/
session_start();
include ('include/header.html');
require ('include/config.inc.php');
require ('model/data_functions.php');
$user_id = $_SESSION['user_id'];																				// Assign the sessions varibles
$email = $_SESSION['email'];
$page = $_SERVER['REQUEST_URI'];																				// Assign URL to use in the form action- This will include the GET date for the week of Monday...
$nav_href = 'edit_servicemeeting.php?monday=';																	// For use in week_nav()
$meeting = 'service_meet';
$user_auth = 'fail';
$user_auth =& user_auth($user_id, $email, $meeting);
if ($user_auth == 0) {																							// If either public or admin is TRUE (1), then the script continue
	require ('include/login_functions.inc.php');
	redirect_user('index.php'); 
} else {
	require ('include/functions.inc.php');
	require ('include/functions_date.php');
	$monday = $_GET['monday']; 																					// Date value from URL. Always represents the date of a Monday of the week.
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('F j, Y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('F j, Y', strtotime('+6 days', strtotime($monday)));
	$page_id = 4;
	$meeting_type_id = 1;
	$part_1 = 17;
	$part_2 = 18;
	$part_3 = 19;
	$close_prayer = 32;
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['part_1'])) {										// *** Update or insert part_1 assignment ***
		$user_id = $_POST['part_1'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $part_1, $page_id);		// meeting_type_id = 1, assign_type_id = 17, page_id = 4
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['part_2'])) {										// *** Update or insert part_2 assignment ***
		$user_id = $_POST['part_2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $part_2, $page_id);		// meeting_type_id = 1, assign_type_id = 18, page_id = 4
	}
 	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['part_3'])) {										// *** Update or insert part_3 assignment ***
		$user_id = $_POST['part_3'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $part_3, $page_id);		// meeting_type_id = 1, assign_type_id = 19, page_id = 4
	}
 	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['close_prayer'])) {								// *** Update or insert close_prayer assignment ***
		$user_id = $_POST['close_prayer'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $close_prayer, $page_id);	// meeting_type_id = 1, assign_type_id = 32, page_id = 4
	}
	$cts_r =& cts_detail ($monday);																				// Get the material for the Service Meeting
	while ($cts_row = mysqli_fetch_array($cts_r)) {
		$sm_1 = $cts_row['sm_1'];
		$sm_2 = $cts_row['sm_2'];
		$sm_3 = $cts_row['sm_3'];
	}
	$r1 =& show_approved(serv_meet);
	$r2 =& show_approved(serv_meet);
	$r3 =& show_approved(serv_meet);
	$r4 =& show_approved(prayer);
	$row_part_1 =& assign_record_exists($monday, $page_id, $part_1);											// Database query variables for when assignment record exists. The query returns data from users table and assignments table.
	$num_row_part_1 = mysqli_num_rows($row_part_1);																//page_id = 4 AND assign_type_id = 17 // part_1 query
	$row_part_2 =& assign_record_exists($monday, $page_id, $part_2);											//page_id = 4 AND assign_type_id = 18 // part_2 query
	$num_row_part_2 = mysqli_num_rows($row_part_2);
	$row_part_3 =& assign_record_exists($monday, $page_id, $part_3);											//page_id = 4 AND assign_type_id = 19 // part_3 query
	$num_row_part_3 = mysqli_num_rows($row_part_3);
	$row_close_prayer =& assign_record_exists($monday, $page_id, $close_prayer);								//page_id = 4 AND assign_type_id = 32 // close_prayer query
	$num_row_close_prayer = mysqli_num_rows($row_close_prayer);
	
	if ($num_row_part_1 = 1) {
		$opt_1 = '<option value="'.$row_part_1['user_id'].'" selected>'.$row_part_1['Name'].'</option>';
		while ($row1 = mysqli_fetch_array($r1)) {
			$opt_1 .= '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
		}
	} else {
		while ($row1 = mysqli_fetch_array($r1)) {
			$opt_1 = '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
		}
	}
	if ($num_row_part_2 = 1) {
		$opt_2 = '<option value="'.$row_part_2['user_id'].'" selected>'.$row_part_2['Name'].'</option>';
		while ($row2 = mysqli_fetch_array($r2)) {
			$opt_2 .= '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
		}
	} else {
		while ($row2 = mysqli_fetch_array($r2)) {
			$opt_2 = '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
		}
	}
	if ($num_row_part_3 = 1) {
		$opt_3 = '<option value="'.$row_part_3['user_id'].'" selected>'.$row_part_3['Name'].'</option>';
		while ($row3 = mysqli_fetch_array($r3)) {
			$opt_3 .= '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
		}
	} else {
		while ($row3 = mysqli_fetch_array($r3)) {
			$opt_3 = '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
		}
	}
	if ($num_row_close_prayer = 1) {
		$opt_4 = '<option value="'.$row_close_prayer['user_id'].'" selected>'.$row_close_prayer['Name'].'</option>';
		while ($row4 = mysqli_fetch_array($r4)) {
			$opt_4 .= '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
		}
	} else {
		while ($row4 = mysqli_fetch_array($r4)) {
			$opt_4 = '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
		}
	}
	include ('view/form_edit_servicemeeting.html'); 															// *** Include the Form ***
	week_nav ($nav_href, $monday);																				// Week to week navigation	
	include('include/footer.html');																				//Include the footer
}
?>