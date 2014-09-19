<?php // - edit_cbs.php
/*Allows a scheduler to assign parts/tasks.
1. Check if user has permission to view the page
2. Display a select/option form for each assignment based on data from the assignments table
3. Each form is submitted when the selection is changed
4. When a form is submitted with a set user id in the POST, then a record in the assignments table is either inserted or updated.*/
session_start();
include ('include/header.html');
require ('include/config.inc.php');
require ('model/data_functions.php');
$user_id = $_SESSION['user_id'];															// Assign the sessions varibles
$email = $_SESSION['email'];
$page = $_SERVER['REQUEST_URI'];															// Assign URL to use in the form action- This will include the GET date for the week of Monday...
$nav_href = 'edit_cbs.php?monday=';															// For use in week_nav()
$meeting = 'cbs';
$user_auth = 'fail';
$user_auth =& user_auth($user_id, $email, $meeting);
if ($user_auth == 0) {																		// If either public or admin is TRUE (1), then the script continue
	require ('include/login_functions.inc.php');
	redirect_user('index.php'); 
} else {																					// *** END permission check *** *** Handle the Forms ***
	require ('include/functions.inc.php');
	require ('include/functions_date.php');
	$monday = $_GET['monday'];																// Date value from URL. Always represents the date of a Monday of the week
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('F j, Y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('F j, Y', strtotime('+6 days', strtotime($monday)));
	$page_id = 2;
	$meeting_type_id = 1;
	$overseer = 3;
	$reader = 4;
	$open_prayer = 5;
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['overseer'])) {				// *** Update or insert overseer assignment ***
		$user_id = $_POST['overseer'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $overseer, $page_id);				// meeting_type_id = 1, assign_type_id = 3, page_id = 2
	 }																						// ***  END Update or insert overseer assignment ***
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['reader'])) {					// *** Update or insert reader assignment ***
		$user_id = $_POST['reader'];														// Assign user id to variable - Check if form is posted and if the user id value is set in the post
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $reader, $page_id);				// meeting_type_id = 1, assign_type_id = 4, page_id = 2
 	}																						// ***  END Update or insert reader assignment ***
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['open_prayer'])) {			// *** Update or insert open_prayer assignment ***
		$user_id = $_POST['open_prayer'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $open_prayer, $page_id);				// meeting_type_id = 1, assign_type_id = 5, page_id = 2
	 }																						// *** END Update or insert open_prayer assignment ***
																							// *** END Handle the Forms ***
	$cts_r =& cts_detail ($monday);															// Get the material for the Cong Bible Study
	while ($cts_row = mysqli_fetch_array($cts_r)) {
		$cbs = $cts_row['cbs'];
		$cbs_url = $cts_row['cbs_url'];
	}
	$r1 =& show_approved(overseer);															// *** Database query variables for forms SELECT options ***
	$r2 =& show_approved(reader);															// Database query variables for when there is no assignment record yet existing - servant_type_id 1 = elder; servant_type_id 2 = ministerial servant
	$r3 =& show_approved(prayer);															// Database query variables for when there is no assignment record yet existing - Show those who are approved for various assignments
																							// Database query variables for when assignment record exists. The query returns data from users table and assignments table
	$row_overseer =& assign_record_exists($monday, 2, $overseer);									// overseer query page_id = 2 AND assign_type_id = 3
	$num_row_overseer = mysqli_num_rows($row_overseer);
	$row_reader =& assign_record_exists($monday, 2, $reader);										// reader query page_id = 2 AND assign_type_id = 4
	$num_row_reader = mysqli_num_rows($row_reader);
	$row_open_prayer =& assign_record_exists($monday, 2, $open_prayer);								// open_prayer query page_id = 2 AND assign_type_id = 5
	$num_row_open_prayer = mysqli_num_rows($row_open_prayer);								// *** END Database query variables for forms select options ***
	if ($num_row_overseer = 1) {
		$opt_1 = '<option value="'.$row_overseer['user_id'].'" selected>'.$row_overseer['Name'].'</option>';
		while ($row1 = mysqli_fetch_array($r1)) {
			$opt_1 .= '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
		}
	} else {
		while ($row1 = mysqli_fetch_array($r1)) {
			$opt_1 = '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
		}
	}
	if ($num_row_reader = 1) {
		$opt_2 = '<option value="'.$row_reader['user_id'].'" selected>'.$row_reader['Name'].'</option>';
		while ($row2 = mysqli_fetch_array($r2)) {
			$opt_2 .= '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
		}
	} else {
		while ($row2 = mysqli_fetch_array($r2)) {
			$opt_2 = '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
		}
	}
	if ($num_row_open_prayer = 1) {
		$opt_3 = '<option value="'.$row_open_prayer['user_id'].'" selected>'.$row_open_prayer['Name'].'</option>';
		while ($row3 = mysqli_fetch_array($r3)) {
			$opt_3 .= '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
		}
	} else {
		while ($row3 = mysqli_fetch_array($r3)) {
			$opt_3 = '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
		}
	}
	include ('view/form_edit_cbs.html'); 													// *** Include the Form ***
	
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