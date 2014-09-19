<?php // - edit_attendents.php
/*Allows a scheduler to assign parts/tasks.
1. Check if user has permission to view the page
2. Display a select/option form for each assignment based on data from the assignments table
3. Each form is submitted when the selection is changed
4. When a form is submitted with a set user id in the POST, then a record in the assignments table is either inserted or updated.*/
session_start();
include ('include/header.html');
require ('include/config.inc.php');
require ('model/data_functions.php');
$user_id = $_SESSION['user_id'];																// Assign the sessions varibles
$email = $_SESSION['email'];
$page = $_SERVER['REQUEST_URI'];																// Assign URL to use in the form action- This will include the GET date for the week of Monday...
$nav_href = 'edit_attendents.php?monday=';														// For use in week_nav()
$meeting = 'attendants';
$user_auth =& user_auth($user_id, $email, $meeting);
if ($user_auth == 0) {																			// *** Check if user has permission to view the page ***
	require ('include/login_functions.inc.php');												// If neither public nor admin is TRUE (1), the user is redirected to index
	redirect_user('index.php'); 																// If either public or admin is TRUE (1), then the script continues
} else {
	require ('include/functions.inc.php');														// *** Handle the Forms ***
	require ('include/functions_date.php');
	$monday = $_GET['monday'];																	// Date value from URL - Always represents the date of a Monday of the week
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('F j, Y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('F j, Y', strtotime('+6 days', strtotime($monday)));
	$page_id = 5;
	$attend1_meet1 = 28;
	$attend2_meet1 = 29;
	$attend1_meet2 = 30;
	$attend2_meet2 = 31;
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['attend1_meet1'])) {				// *** Update or insert attend1_meet2 assignment ***
		$user_id = $_POST['attend1_meet1'];														// Assign user id to variable
		$conflict_msg =& handle_assignment_post($monday, $user_id, 1, $attend1_meet1, $page_id);	// meeting_type_id = 2, assign_type_id = 28, page_id = 5
	}																							// ***  END Update or insert attend1_meet2 assignment ***
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['attend2_meet1'])) {				// *** Update or insert attend2_meet2 assignment ***
		$user_id = $_POST['attend2_meet1'];														// Assign user id to variable
		$conflict_msg =& handle_assignment_post($monday, $user_id, 1, $attend2_meet1, $page_id);	// meeting_type_id = 2, assign_type_id = 29, page_id = 5
	}																							// ***  END Update or insert attend2_meet2 assignment ***
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['attend1_meet2'])) {				// *** Update or insert attend1_meet1 assignment ***
		$user_id = $_POST['attend1_meet2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, $attend1_meet2, $page_id);	// meeting_type_id = 1, assign_type_id = 30, page_id = 5
	}																							// ***  END Update or insert attend1_meet1 assignment ***	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['attend2_meet2'])) {				// *** Update or insert attend2_meet1 assignment ***
		$user_id = $_POST['attend2_meet2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, $attend2_meet2, $page_id);	// meeting_type_id = 1, assign_type_id = 31, page_id = 5
	}																							// *** END Update or insert attend2_meet1 assignment ***
																								// *** END Handle the Forms. ***
	$r1 =& show_approved(attend);																// *** Database query variables for forms select options ***
	$r2 =& show_approved(attend);																// Query in functions filter for those approved for assignments
	$r3 =& show_approved(attend);
	$r4 =& show_approved(attend);
																								// Database query variables for when assignment record exists. The query returns data from users table and assignments table.
	$row_attend1_meet1 =& assign_record_exists($monday, $page_id, $attend1_meet1);					// attend1_meet2 query - page_id = 5 AND assign_type_id = 28
	$num_row_attend1_meet1 = mysqli_num_rows($row_attend1_meet1);
	$row_attend2_meet1 =& assign_record_exists($monday, $page_id, $attend2_meet1);					// attend2_meet2 query - page_id = 5 AND assign_type_id = 29
	$num_row_attend2_meet1 = mysqli_num_rows($row_attend2_meet1);
	$row_attend1_meet2 =& assign_record_exists($monday, $page_id, $attend1_meet2);					// attend1_meet1 query - page_id = 5 AND assign_type_id = 30
	$num_row_attend1_meet2 = mysqli_num_rows($row_attend1_meet2);
	$row_attend2_meet2 =& assign_record_exists($monday, $page_id, $attend2_meet2);					// attend2_meet1 query - page_id = 5 AND assign_type_id = 31
	$num_row_attend2_meet2 = mysqli_num_rows($row_attend2_meet2);								// *** END Database query variables for forms select options ***
																								// *** Create the Forms. Each form submits when a selection option is chosen. ***
	if ($num_row_attend1_meet1 = 1) {
		$opt_1 = '<option value="'.$row_attend1_meet1['user_id'].'" selected>'.$row_attend1_meet1['Name'].'</option>';
		while ($row1 = mysqli_fetch_array($r1)) {
			$opt_1 .= '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
		}
	} else {
		while ($row1 = mysqli_fetch_array($r1)) {
			$opt_1 = '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
		}
	}
	if ($num_row_attend2_meet1 = 1) {
		$opt_2 = '<option value="'.$row_attend2_meet1['user_id'].'" selected>'.$row_attend2_meet1['Name'].'</option>';
		while ($row2 = mysqli_fetch_array($r2)) {
			$opt_2 .= '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
		}
	} else {
		while ($row2 = mysqli_fetch_array($r2)) {
			$opt_2 = '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
		}
	}
	if ($num_row_attend1_meet2 = 1) {
		$opt_3 = '<option value="'.$row_attend1_meet2['user_id'].'" selected>'.$row_attend1_meet2['Name'].'</option>';
		while ($row3 = mysqli_fetch_array($r3)) {
			$opt_3 .= '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
		}
	} else {
		while ($row3 = mysqli_fetch_array($r3)) {
			$opt_3 = '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
		}
	}
	if ($num_row_attend2_meet2 = 1) {
		$opt_4 = '<option value="'.$row_attend2_meet2['user_id'].'" selected>'.$row_attend2_meet2['Name'].'</option>';
		while ($row4 = mysqli_fetch_array($r4)) {
			$opt_4 .= '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
		}
	} else {
		while ($row4 = mysqli_fetch_array($r4)) {
			$opt_4 = '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
		}
	}	
	include ('view/form_edit_attendents.html');	
	week_nav ($nav_href, $monday, $prevw, $currw, $nextw);										// Week to week navigation
	include ('include/footer.html');																// Include the footer
}
?>