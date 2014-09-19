<?php // - edit_sound.php
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
$page = $_SERVER['REQUEST_URI'];																		// Assign URL to use in the form action- This will include the GET date for the week of Monday...
$nav_href = 'edit_sound.php?monday=';																			// For use in week_nav()
$meeting = 'sound_stage';
$user_auth =& user_auth($user_id, $email, $meeting);
if ($user_auth == 0) {																							// *** Check if user has permission to view the page ***
	require ('include/login_functions.inc.php');																// If neither public nor admin is TRUE (1), the user is redirected to index
	redirect_user('index.php'); 																				// If either public or admin is TRUE (1), then the script continues
} else {
	require ('include/functions.inc.php');																		// *** Handle the Forms ***
	require ('include/functions_date.php');
	$monday = $_GET['monday'];																					// Date value from URL - Always represents the date of a Monday of the week
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('F j, Y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('F j, Y', strtotime('+6 days', strtotime($monday)));
	$page_id = 6;
	$sound_meet2 = 20;
	$stage_meet2 = 21;
	$mic1_meet2 = 22;
	$mic2_meet2 = 23;
	$sound_meet1 = 24;
	$stage_meet1 = 25;
	$mic1_meet1 = 26;
	$mic2_meet1 = 27;	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['sound_meet2'])) {								// *** Update or insert sound_meet2 assignment ***
		$user_id = $_POST['sound_meet2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, $sound_meet2, $page_id);					// meeting_type_id = 2, assign_type_id = 20, page_id = 6
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['stage_meet2'])) {								// *** Update or insert stage_meet2 assignment ***
		$user_id = $_POST['stage_meet2']; // Assign user id to variable.
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, $stage_meet2, $page_id);					// meeting_type_id = 2, assign_type_id = 21, page_id = 6
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['sound_meet1'])) {								// *** Update or insert sound_meet1 assignment ***
		$user_id = $_POST['sound_meet1'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 1, $sound_meet1, $page_id);					// meeting_type_id = 1, assign_type_id = 24, page_id = 6
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['stage_meet1'])) {								// *** Update or insert stage_meet1 assignment ***
		$user_id = $_POST['stage_meet1'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 1, $stage_meet1, $page_id);					// meeting_type_id = 1, assign_type_id = 25, page_id = 6
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['mic1_meet2'])) {									// *** Update or insert mic1_meet2 assignment ***
		$user_id = $_POST['mic1_meet2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, $mic1_meet2, $page_id);					// meeting_type_id = 2, assign_type_id = 22, page_id = 6
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['mic2_meet2'])) {									// *** Update or insert mic2_meet2 assignment ***
		$user_id = $_POST['mic2_meet2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, $mic2_meet2, $page_id);					// meeting_type_id = 2, assign_type_id = 23, page_id = 6
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['mic1_meet1'])) {									// *** Update or insert mic1_meet1 assignment ***
		$user_id = $_POST['mic1_meet1'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 1, $mic1_meet1, $page_id);					// meeting_type_id = 1, assign_type_id = 26, page_id = 6
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['mic2_meet1'])) {									// *** Update or insert mic2_meet1 assignment ***
		$user_id = $_POST['mic2_meet1'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 1, $mic2_meet1, $page_id);					// meeting_type_id = 1, assign_type_id = 27, page_id = 6
	}
	$r1 =& show_approved(sound_panel);																			// query in functions filter for those approved for assignments
	$r2 =& show_approved(stage);
	$r3 =& show_approved(mic);
	$r4 =& show_approved(mic);
	$r5 =& show_approved(sound_panel);
	$r6 =& show_approved(stage);
	$r7 =& show_approved(mic);
	$r8 =& show_approved(mic);
																												// Database query variables for when assignment record exists. The query returns data from users table and assignments table.
	$row_sound_meet2 =& assign_record_exists($monday, $page_id, $sound_meet2);									//page_id = 6 AND assign_type_id = 20 // sound_meet2 query
	$num_row_sound_meet2 = mysqli_num_rows($row_sound_meet2);
	$row_stage_meet2 =& assign_record_exists($monday, $page_id, $stage_meet2);									//page_id = 6 AND assign_type_id = 21 // stage_meet2 query
	$num_row_stage_meet2 = mysqli_num_rows($row_stage_meet2);
	$row_sound_meet1 =& assign_record_exists($monday, $page_id, $sound_meet1);									//page_id = 6 AND assign_type_id = 24 // sound_meet1 query
	$num_row_sound_meet1 = mysqli_num_rows($row_sound_meet1);
	$row_stage_meet1 =& assign_record_exists($monday, $page_id, $stage_meet1);									//page_id = 6 AND assign_type_id = 25 // stage_meet1 query
	$num_row_stage_meet1 = mysqli_num_rows($row_stage_meet1);	
	$row_mic1_meet2 =& assign_record_exists($monday, $page_id, $mic1_meet2);									//page_id = 6 AND assign_type_id = 22 // mic1_meet2 query
	$num_row_mic1_meet2 = mysqli_num_rows($row_mic1_meet2);
	$row_mic2_meet2 =& assign_record_exists($monday, $page_id, $mic2_meet2);									//page_id = 6 AND assign_type_id = 23 // mic2_meet2 query
	$num_row_mic2_meet2 = mysqli_num_rows($row_mic2_meet2);
	$row_mic1_meet1 =& assign_record_exists($monday, $page_id, $mic1_meet1);									//page_id = 6 AND assign_type_id = 26 // mic1_meet1 query
	$num_row_mic1_meet1 = mysqli_num_rows($row_mic1_meet1);
	$row_mic2_meet1 =& assign_record_exists($monday, $page_id, $mic2_meet1);									//page_id = 6 AND assign_type_id = 27 // mic2_meet1 query
	$num_row_mic2_meet1 = mysqli_num_rows($row_mic2_meet1);														// *** END Database query variables for forms select options ***
	if ($num_row_sound_meet1 = 1) {																				// If the query returns a record matching the date, assignment type and meeting, then use it for the selected option and also include the all the other names or else just show all the names in the option. Also the option assigns the user ID to its value, which is used in the POST check conditionals.
		$opt_1 = '<option value="'.$row_sound_meet1['user_id'].'" selected>'.$row_sound_meet1['Name'].'</option>';
		while ($row5 = mysqli_fetch_array($r5)) {
			$opt_1 .= '<option value="'.$row5['user_id'].'">'.$row5['Name'].'</option>';
		}
	} else {
		while ($row5 = mysqli_fetch_array($r5)) {
			$opt_1 = '<option value="'.$row5['user_id'].'">'.$row5['Name'].'</option>';
		}
	}
	if ($num_row_stage_meet1 = 1) {
		$opt_2 = '<option value="'.$row_stage_meet1['user_id'].'" selected>'.$row_stage_meet1['Name'].'</option>';
		while ($row6 = mysqli_fetch_array($r6)) {
			$opt_2 .= '<option value="'.$row6['user_id'].'">'.$row6['Name'].'</option>';
		}
	} else {
		while ($row6 = mysqli_fetch_array($r6)) {
			$opt_2 = '<option value="'.$row6['user_id'].'">'.$row6['Name'].'</option>';
		}
	}		
	if ($num_row_mic1_meet1 = 1) {
		$opt_3 = '<option value="'.$row_mic1_meet1['user_id'].'" selected>'.$row_mic1_meet1['Name'].'</option>';
		while ($row7 = mysqli_fetch_array($r7)) {
			$opt_3 .= '<option value="'.$row7['user_id'].'">'.$row7['Name'].'</option>';
		}
	} else {
		while ($row7 = mysqli_fetch_array($r7)) {
			$opt_3 = '<option value="'.$row7['user_id'].'">'.$row7['Name'].'</option>';
		}
	}		
	if ($num_row_mic2_meet1 = 1) {
		$opt_4 = '<option value="'.$row_mic2_meet1['user_id'].'" selected>'.$row_mic2_meet1['Name'].'</option>';
		while ($row8 = mysqli_fetch_array($r8)) {
			$opt_4 .= '<option value="'.$row8['user_id'].'">'.$row8['Name'].'</option>';
		}
	} else {
		while ($row8 = mysqli_fetch_array($r8)) {
			$opt_4 = '<option value="'.$row8['user_id'].'">'.$row8['Name'].'</option>';
		}
	}		
	if ($num_row_sound_meet2 = 1) {
		$opt_5 = '<option value="'.$row_sound_meet2['user_id'].'" selected>'.$row_sound_meet2['Name'].'</option>';
		while ($row1 = mysqli_fetch_array($r1)) {
			$opt_5 .= '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
		}
	} else {
		while ($row1 = mysqli_fetch_array($r1)) {
			$opt_5 = '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
		}
	}		
	if ($num_row_stage_meet2 = 1) {
		$opt_6 = '<option value="'.$row_stage_meet2['user_id'].'" selected>'.$row_stage_meet2['Name'].'</option>';
		while ($row2 = mysqli_fetch_array($r2)) {
			$opt_6 .= '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
		}
	} else {
		while ($row2 = mysqli_fetch_array($r2)) {
			$opt_6 = '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
		}
	}		
	if ($num_row_mic1_meet2 = 1) {
		$opt_7 = '<option value="'.$row_mic1_meet2['user_id'].'" selected>'.$row_mic1_meet2['Name'].'</option>';
		while ($row3 = mysqli_fetch_array($r3)) {
			$opt_7 .= '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
		}
	} else {
		while ($row3 = mysqli_fetch_array($r3)) {
			$opt_7 = '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
		}
	}		
	if ($num_row_mic2_meet2 = 1) {
		$opt_8 = '<option value="'.$row_mic2_meet2['user_id'].'" selected>'.$row_mic2_meet2['Name'].'</option>';
		while ($row4 = mysqli_fetch_array($r4)) {
			$opt_8 .= '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
		}
	} else {
		while ($row4 = mysqli_fetch_array($r4)) {
			$opt_8 = '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
		}
	}		
	include ('view/form_edit_sound.html');
	week_nav ($nav_href, $monday, $prevw, $currw, $nextw);										// Week to week navigation
	include ('include/footer.html');																// Include the footer
}
?>