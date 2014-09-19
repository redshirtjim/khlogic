<?php // - edit_tms.php
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
$nav_href = 'edit_tms.php?monday=';																	// For use in week_nav()
$meeting = 'tms';
$user_auth = 'fail';
$user_auth =& user_auth($user_id, $email, $meeting);
if ($user_auth == 0) {																							// If either public or admin is TRUE (1), then the script continue
	require ('include/login_functions.inc.php');
	redirect_user('index.php'); 
} else {
	require ('include/functions.inc.php');
	require ('include/functions_date.php');
	$monday = $_GET['monday']; 																						// Date value from URL. Always represents the date of a Monday of the week.
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('F j, Y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('F j, Y', strtotime('+6 days', strtotime($monday)));
	$view = 'date';
	$page_id = 3;
	$meeting_type_id = 1;
	$highlights = 7;
	$main_1 = 8;
	$main_2 = 9;
	$main_2_hh = 33;
	$main_3 = 10;
	$main_3_hh = 34;
	$second_1 = 11;
	$second_2 = 12;
	$second_2_hh = 35;
	$second_3 = 13;
	$second_3_hh = 36;
	$third_1 = 14;
	$third_2 = 15;
	$third_2_hh = 37;
	$third_3 = 16;
	$third_3_hh = 38;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['no_schools'])) {
		$no_schools = $_POST['no_schools'];
		$no_schools_msg =& no_schools($monday, $no_schools);
		echo $no_schools_msg;
	}
	$row_school =& no_schools_assigned($monday);
	if ($row_school) {
		$curr_school = $row_school['no_schools'];
	} else {
		$curr_school = NUMBER_SCHOOLS;
	}
	$opt_no_schools = '<option value="' . $curr_school . '" selected>' . $curr_school . '</option>';
	$opt_no_schools .= '<option value="1">1</option>';
	$opt_no_schools .= '<option value="2">2</option>';
	$opt_no_schools .= '<option value="3">3</option>';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['highlights'])) {										// *** Update or insert highlights assignment ***
		$user_id = $_POST['highlights'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $highlights, $page_id);		// meeting_type_id = 1, assign_type_id = 7, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['highlights_study'])) {
		$study_id = $_POST['highlights_study'];																		// Assign study id to variable.
		handle_study_post($monday, $study_id, $meeting_type_id, $highlights, $page_id);								// meeting_type_id = 1, assign_type_id = 7, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_1'])) {											// *** Update or insert main_1 assignment ***
		$user_id = $_POST['main_1'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $main_1, $page_id);			// meeting_type_id = 1, assign_type_id = 8, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_1_study'])) {
		$study_id = $_POST['main_1_study'];
		handle_study_post($monday, $study_id, $meeting_type_id, $main_1, $page_id);									// meeting_type_id = 1, assign_type_id = 8, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_2'])) {											// *** Update or insert main_2 assignment ***
		$user_id = $_POST['main_2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, 9, $page_id);					// meeting_type_id = 1, assign_type_id = 9, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_2_study'])) {
		$study_id = $_POST['main_2_study'];
		handle_study_post($monday, $study_id, $meeting_type_id, 9, $page_id);										// meeting_type_id = 1, assign_type_id = 9, page_id = 3
	}	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_2_setting'])) {
		$setting_id = $_POST['main_2_setting'];
		handle_setting_post($monday, $setting_id, $meeting_type_id, 9, $page_id);									// meeting_type_id = 1, assign_type_id = 9, page_id = 3
	}			
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_2_hh'])) {										// *** Update or insert main_2 householder assignment ***
		$user_id = $_POST['main_2_hh'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $main_2_hh, $page_id);			// meeting_type_id = 1, assign_type_id = 33, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_3'])) {											// *** Update or insert main_3 assignment ***
		$user_id = $_POST['main_3'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $main_3, $page_id);			// meeting_type_id = 1, assign_type_id = 10, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_3_study'])) {
		$study_id = $_POST['main_3_study'];
		handle_study_post($monday, $study_id, $meeting_type_id, $main_3, $page_id);									// meeting_type_id = 1, assign_type_id = 10, page_id = 3
	}	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_3_setting'])) {
		$setting_id = $_POST['main_3_setting'];
		handle_setting_post($monday, $setting_id, $meeting_type_id, $main_3, $page_id);								// meeting_type_id = 1, assign_type_id = 10, page_id = 3
	}	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['main_3_hh'])) {										// *** Update or insert main_3 householder assignment ***
		$user_id = $_POST['main_3_hh'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $main_3_hh, $page_id);			// meeting_type_id = 1, assign_type_id = 34, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_1'])) {										
		$user_id = $_POST['second_1'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $second_1, $page_id);			// meeting_type_id = 1, assign_type_id = 11, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_1_study'])) {
		$study_id = $_POST['second_1_study'];
		handle_study_post($monday, $study_id, $meeting_type_id, $second_1, $page_id);								// meeting_type_id = 1, assign_type_id = 11, page_id = 3
	}	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_2'])) {										// *** Update or insert second_2 assignment ***
		$user_id = $_POST['second_2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $second_2, $page_id);			// meeting_type_id = 1, assign_type_id = 12, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_2_study'])) {
		$study_id = $_POST['second_2_study'];
		handle_study_post($monday, $study_id, $meeting_type_id, $second_2, $page_id);								// meeting_type_id = 1, assign_type_id = 12, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_2_setting'])) {
		$setting_id = $_POST['second_2_setting'];
		handle_setting_post($monday, $setting_id, $meeting_type_id, $second_2, $page_id);							// meeting_type_id = 1, assign_type_id = 12, page_id = 3
	}	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_2_hh'])) {									// *** Update or insert second_2 householder assignment ***
		$user_id = $_POST['second_2_hh'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $second_2_hh, $page_id);		// meeting_type_id = 1, assign_type_id = 35, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_3'])) {										// *** Update or insert second_3 assignment ***
		$user_id = $_POST['second_3'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $second_3, $page_id);			// meeting_type_id = 1, assign_type_id = 13, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_3_study'])) {
		$study_id = $_POST['second_3_study'];
		handle_study_post($monday, $study_id, $meeting_type_id, $second_3, $page_id);								// meeting_type_id = 1, assign_type_id = 13, page_id = 3
	}	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_3_setting'])) {
		$setting_id = $_POST['second_3_setting'];
		handle_setting_post($monday, $setting_id, $meeting_type_id, $second_3, $page_id);							// meeting_type_id = 1, assign_type_id = 13, page_id = 3
	}	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['second_3_hh'])) {									// *** Update or insert second_3 householder assignment ***
		$user_id = $_POST['second_3_hh'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $second_3_hh, $page_id);		// meeting_type_id = 1, assign_type_id = 36, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['third_1'])) {										// *** Update or insert third_1 assignment ***
		$user_id = $_POST['third_1'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $third_1, $page_id);			// meeting_type_id = 1, assign_type_id = 14, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['third_2'])) {										// *** Update or insert third_2 assignment ***
		$user_id = $_POST['third_2'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $third_2, $page_id);			// meeting_type_id = 1, assign_type_id = 15, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['third_2_hh'])) {										// *** Update or insert third_2 householder assignment ***
		$user_id = $_POST['third_2_hh'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $third_2_hh, $page_id);		// meeting_type_id = 1, assign_type_id = 37, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['third_3'])) {										// *** Update or insert third_3 assignment ***
		$user_id = $_POST['third_3'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $third_3, $page_id);			// meeting_type_id = 1, assign_type_id = 16, page_id = 3
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['third_3_hh'])) {										// *** Update or insert third_3 householder assignment ***
		$user_id = $_POST['third_3_hh'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, $meeting_type_id, $third_3_hh, $page_id);		// meeting_type_id = 1, assign_type_id = 38, page_id = 3
	}
 	$cts_r =& cts_detail ($monday);																					// Get the material for the TMS
	while ($cts_row = mysqli_fetch_array($cts_r)) {
		$song_1 = $cts_row['song_1'];
		$cbs = $cts_row['cbs'];
		$bible_read = '<a href="http://wol.jw.org/en/wol/l/r1/lp-e?q=' . $cts_row['bible_read'] . '" target="blank">' . $cts_row['bible_read'] . '</a>';
		$no_1 = '<a href="http://wol.jw.org/en/wol/l/r1/lp-e?q=' . $cts_row['no_1'] . '" target="blank">' . $cts_row['no_1'] . '</a>';
		$no_2 = $cts_row['no_2'] . ' (<a href="' . $cts_row['no_2_url'] . '" target="blank">' . $cts_row['no_2_source'] . '</a>)';
		$no_3 = $cts_row['no_3'] . ' (<a href="' . $cts_row['no_3_url'] . '" target="blank">' . $cts_row['no_3_source'] . '</a>)';
		$song_2 = $cts_row['song_2'];
		$sm_1 = $cts_row['sm_1'];
		$sm_2 = $cts_row['sm_2'];
		$sm_3 = $cts_row['sm_3'];
		$song_3 = $cts_row['song_3'];
	}
	if (isset($_POST['sort']) && $_POST['sort'] == 'date'){															// *** Database query variables for forms select options ***
		$view = 'date';																								// query in functions filter for those approved for assignments
		$r1 =& show_approved_bydate('u.bible_high', 7);																// Database query variables for when there is no assignment record yet existing 
		$r2 =& show_approved_bydate('u.no_1', 8);																	// servant_type_id 1 = elder; servant_type_id 2 = ministerial servant
		$r3 =& show_approved_bydate('u.no_2', 9);
		$r4 =& show_approved_bydate('u.no_3', 10);
		$r5 =& show_approved_bydate('u.no_1', 11);
		$r6 =& show_approved_bydate('u.no_2', 12);
		$r7 =& show_approved_bydate('u.no_3', 13);
		$r8 =& show_approved_bydate('u.no_1', 14);
		$r9 =& show_approved_bydate('u.no_2', 15);
		$r10 =& show_approved_bydate('u.no_3', 16);
		$r11 =& show_approved_bydate('u.householder', 33);
		$r12 =& show_approved_bydate('u.householder', 34);
		$r32 =& show_approved_bydate('u.householder', 35);
		$r33 =& show_approved_bydate('u.householder', 36);
	} else {
		$view = 'alpha';
		$r1 =& show_approved('bible_high');
		$r2 =& show_approved('no_1');
		$r3 =& show_approved('no_2');
		$r4 =& show_approved('no_3');
		$r5 =& show_approved('no_1');
		$r6 =& show_approved('no_2');
		$r7 =& show_approved('no_3');
		$r8 =& show_approved('no_1');
		$r9 =& show_approved('no_2');
		$r10 =& show_approved('no_3');
		$r11 =& show_approved('householder');
		$r12 =& show_approved('householder');
		$r32 =& show_approved('householder');
		$r33 =& show_approved('householder');
}
	$r13 =& study();
	$r14 =& setting();
	$r15 =& study();
	$r16 =& setting();
	$r17 =& study();
	$r18 =& setting();
	$r19 =& study();
	$r20 =& setting();
	$r21 =& study();
	$r22 =& setting();
	$r23 =& study();
	$r24 =& setting();
	$r25 =& study();
	$r26 =& setting();
	$r27 =& study();
	$r28 =& setting();
	$r29 =& study();
	$r30 =& setting();
	$r31 =& study();
																													// Database query variables for when assignment record exists. The query returns data from users table and assignments table.
	$row_highlights =& assign_record_exists($monday, $page_id, $highlights); 										//page_id = 3 AND assign_type_id = 7// highlights query
	$num_row_highlights = mysqli_num_rows($row_highlights);
	$row_main_1 =& assign_record_exists($monday, $page_id, $main_1); 												//page_id = 3 AND assign_type_id = 8// main_1 query
	$num_row_main_1 = mysqli_num_rows($row_main_1);
	$row_main_2 =& assign_record_exists($monday, $page_id, $main_2); 												//page_id = 3 AND assign_type_id = 9// main_2 query
	$num_row_main_2 = mysqli_num_rows($row_main_2);
	$row_main_2_hh =& assign_record_exists($monday, $page_id, $main_2_hh); 											//page_id = 3 AND assign_type_id = 33// main_2 hh query
	$num_row_main_2_hh = mysqli_num_rows($row_main_2_hh);
	$row_main_3 =& assign_record_exists($monday, $page_id, $main_3); 												//page_id = 3 AND assign_type_id = 10// main_3 query
	$num_row_main_3 = mysqli_num_rows($row_main_3);
	$row_main_3_hh =& assign_record_exists($monday, $page_id, $main_3_hh); 											//page_id = 3 AND assign_type_id = 34// main_3 hh query
	$num_row_main_3_hh = mysqli_num_rows($row_main_3_hh);
	$row_second_1 =& assign_record_exists($monday, $page_id, $second_1); 											//page_id = 3 AND assign_type_id = 11// second_1 query
	$num_row_second_1 = mysqli_num_rows($row_second_1);
	$row_second_2 =& assign_record_exists($monday, $page_id, $second_2); 											//page_id = 3 AND assign_type_id = 12// second_2 query
	$num_row_second_2 = mysqli_num_rows($row_second_2);
	$row_second_2_hh =& assign_record_exists($monday, $page_id, $second_2_hh); 										//page_id = 3 AND assign_type_id = 35// second_2 hh query
	$num_row_second_2_hh = mysqli_num_rows($row_second_2_hh);
	$row_second_3 =& assign_record_exists($monday, $page_id, $second_3); 											//page_id = 3 AND assign_type_id = 13// second_3 query
	$num_row_second_3 = mysqli_num_rows($row_second_3);
	$row_second_3_hh =& assign_record_exists($monday, $page_id, $second_3_hh); 										//page_id = 3 AND assign_type_id = 36// second_3 hh query
	$num_row_second_3_hh = mysqli_num_rows($row_second_3_hh);
	$row_third_1 =& assign_record_exists($monday, $page_id, $third_1); 												//page_id = 3 AND assign_type_id = 14// third_1 query
	$num_row_third_1 = mysqli_num_rows($row_third_1);
	$row_third_2 =& assign_record_exists($monday, $page_id, $third_2); 												//page_id = 3 AND assign_type_id = 15// third_2 query
	$num_row_third_2 = mysqli_num_rows($row_third_2);
	$row_third_2_hh =& assign_record_exists($monday, $page_id, $third_2_hh); 										//page_id = 3 AND assign_type_id = 37// third_2 hh query
	$num_row_third_2_hh = mysqli_num_rows($row_third_2_hh);
	$row_third_3 =& assign_record_exists($monday, $page_id, $third_3); 												//page_id = 3 AND assign_type_id = 16// third_3 query
	$num_row_third_3 = mysqli_num_rows($row_third_3);
	$row_third_3_hh =& assign_record_exists($monday, $page_id, $third_3_hh); 										//page_id = 3 AND assign_type_id = 38// third_3 hh query
	$num_row_third_3_hh = mysqli_num_rows($row_third_3_hh);
	

	if ($num_row_highlights = 1) {
		$opt_highlights = '<option value="'.$row_highlights['user_id'].'" selected>'.$row_highlights['Name'].'</option>';
		while ($row1 = mysqli_fetch_array($r1)) {
			if ($view == 'date') {
				$opt_highlights .= '<option value="'.$row1['user_id'].'">' . $row1['Name'] . ' ... ' . date('F j, Y', strtotime($row1['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_highlights .= '<option value="'.$row1['user_id'].'">' . $row1['Name'] . '</option>';
			}
		}
	} else {
		while ($row1 = mysqli_fetch_array($r1)) {
			if ($view == 'date') {
				$opt_highlights = '<option value="'.$row1['user_id'].'">' . $row1['Name'] . ' ... ' . date('F j, Y', strtotime($row1['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_highlights = '<option value="'.$row1['user_id'].'">' . $row1['Name'] . '</option>';
			}
		}
	}
	if ($num_row_highlights = 1) {
		$opt_highlights_study = '<option value="'.$row_highlights['study_id'].'" selected>'.$row_highlights['Study'].'</option>';
		while ($row31 = mysqli_fetch_array($r31)) {
			$opt_highlights_study .= '<option value="'.$row31['study_id'].'">'.$row31['Study'].'</option>';
		}
	} else {
		while ($row31 = mysqli_fetch_array($r31)) {
			$opt_highlights_study = '<option value="'.$row31['study_id'].'">'.$row31['Study'].'</option>';
		}
	}
	if ($num_row_main_1 = 1) {
		$opt_main_1 = '<option value="'.$row_main_1['user_id'].'" selected>'.$row_main_1['Name'].'</option>';
		while ($row2 = mysqli_fetch_array($r2)) {
			if ($view == 'date') {
				$opt_main_1 .= '<option value="'.$row2['user_id'].'">' . $row2['Name'] . ' ... ' . date('F j, Y', strtotime($row2['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_1 .= '<option value="'.$row2['user_id'].'">' . $row2['Name'] . '</option>';
			}
		}
	} else {
		while ($row2 = mysqli_fetch_array($r2)) {
			if ($view == 'date') {
				$opt_main_1 = '<option value="'.$row2['user_id'].'">' . $row2['Name'] . ' ... ' . date('F j, Y', strtotime($row2['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_1 = '<option value="'.$row2['user_id'].'">' . $row2['Name'] . '</option>';
			}
		}
	}
	if ($num_row_main_1 = 1) {
		$opt_main_1_study = '<option value="'.$row_main_1['study_id'].'" selected>'.$row_main_1['Study'].'</option>';
		while ($row13 = mysqli_fetch_array($r13)) {
			$opt_main_1_study .= '<option value="'.$row13['study_id'].'">'.$row13['Study'].'</option>';
		}
	} else {
		while ($row13 = mysqli_fetch_array($r13)) {
			$opt_main_1_study = '<option value="'.$row13['study_id'].'">'.$row13['Study'].'</option>';
		}
	}
	if ($num_row_main_2 = 1) {
		$opt_main_2 = '<option value="'.$row_main_2['user_id'].'" selected>'.$row_main_2['Name'].'</option>';
		while ($row3 = mysqli_fetch_array($r3)) {
			if ($view == 'date') {
				$opt_main_2 .= '<option value="'.$row3['user_id'].'">' . $row3['Name'] . ' ... ' . date('F j, Y', strtotime($row3['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_2 .= '<option value="'.$row3['user_id'].'">' . $row3['Name'] . '</option>';
			}
		}
	} else {
		while ($row3 = mysqli_fetch_array($r3)) {
			if ($view == 'date') {
				$opt_main_2 = '<option value="'.$row3['user_id'].'">' . $row3['Name'] . ' ... ' . date('F j, Y', strtotime($row3['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_2 = '<option value="'.$row3['user_id'].'">' . $row3['Name'] . '</option>';
			}
		}
	}
	if ($num_row_main_2 = 1) {
		$opt_main_2_study = '<option value="'.$row_main_2['study_id'].'" selected>'.$row_main_2['Study'].'</option>';
		while ($row15 = mysqli_fetch_array($r15)) {
			$opt_main_2_study .= '<option value="'.$row15['study_id'].'">'.$row15['Study'].'</option>';
		}
	} else {
		while ($row15 = mysqli_fetch_array($r15)) {
			$opt_main_2_study = '<option value="'.$row15['study_id'].'">'.$row15['Study'].'</option>';
		}
	}
	if ($num_row_main_2_hh = 1) {
		$opt_main_2_hh =  '<option value="'.$row_main_2_hh['user_id'].'" selected>'.$row_main_2_hh['Name'].'</option>';
		while ($row11 = mysqli_fetch_array($r11)) {
			if ($view == 'date') {
				$opt_main_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . ' ... ' . date('F j, Y', strtotime($row11['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . '</option>';
			}
		}
	} else {
		while ($row11 = mysqli_fetch_array($r11)) {
			if ($view == 'date') {
				$opt_main_2_hh =  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . ' ... ' . date('F j, Y', strtotime($row11['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . '</option>';
			}
		}
	}
	if ($num_row_main_2 = 1) {
		$opt_main_2_setting = '<option value="'.$row_main_2['setting_id'].'" selected>'.$row_main_2['Setting'].'</option>';
		while ($row16 = mysqli_fetch_array($r16)) {
			$opt_main_2_setting .= '<option value="'.$row16['setting_id'].'">'.$row16['Setting'].'</option>';
		}
	} else {
		while ($row16 = mysqli_fetch_array($r16)) {
			$opt_main_2_setting = '<option value="'.$row16['setting_id'].'">'.$row16['Setting'].'</option>';
		}
	}
	if ($num_row_main_3 = 1) {
		$opt_main_3 = '<option value="'.$row_main_3['user_id'].'" selected>'.$row_main_3['Name'].'</option>';
		while ($row4 = mysqli_fetch_array($r4)) {
			if ($view == 'date') {
				$opt_main_3 .= '<option value="'.$row4['user_id'].'">' . $row4['Name'] . ' ... ' . date('F j, Y', strtotime($row4['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_3 .= '<option value="'.$row4['user_id'].'">' . $row4['Name'] . '</option>';
			}
		}
	} else {
		while ($row4 = mysqli_fetch_array($r4)) {
			if ($view == 'date') {
				$opt_main_3 = '<option value="'.$row4['user_id'].'">' . $row4['Name'] . ' ... ' . date('F j, Y', strtotime($row4['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_3 = '<option value="'.$row4['user_id'].'">' . $row4['Name'] . '</option>';
			}
		}
	}
	if ($num_row_main_3 = 1) {
		$opt_main_3_study = '<option value="'.$row_main_3['study_id'].'" selected>'.$row_main_3['Study'].'</option>';
		while ($row17 = mysqli_fetch_array($r17)) {
			$opt_main_3_study .= '<option value="'.$row17['study_id'].'">'.$row17['Study'].'</option>';
		}
	} else {
		while ($row17 = mysqli_fetch_array($r17)) {
			$opt_main_3_study = '<option value="'.$row17['study_id'].'">'.$row17['Study'].'</option>';
		}
	}
	if ($num_row_main_3_hh = 1) {
		$opt_main_3_hh = '<option value="'.$row_main_3_hh['user_id'].'" selected>'.$row_main_3_hh['Name'].'</option>';
		while ($row12 = mysqli_fetch_array($r12)) {
			if ($view == 'date') {
				$opt_main_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . ' ... ' . date('F j, Y', strtotime($row12['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . '</option>';
			}
		}
	} else {
		while ($row12 = mysqli_fetch_array($r12)) {
			if ($view == 'date') {
				$opt_main_3_hh = '<option value="'.$row12['user_id'].'">' . $row12['Name'] . ' ... ' . date('F j, Y', strtotime($row12['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_main_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . '</option>';
			}
		}
	}
	if ($num_row_main_3 = 1) {
			$opt_main_3_setting = '<option value="'.$row_main_3['setting_id'].'" selected>'.$row_main_3['Setting'].'</option>';
			while ($row18 = mysqli_fetch_array($r18)) {
				$opt_main_3_setting .= '<option value="'.$row18['setting_id'].'">'.$row18['Setting'].'</option>';
			}
	} else {
		while ($row18 = mysqli_fetch_array($r18)) {
			$opt_main_3_setting = '<option value="'.$row18['setting_id'].'">'.$row18['Setting'].'</option>';
		}
	}
	// SECOND
	if ($num_row_second_1 = 1) {
		$opt_second_1 = '<option value="'.$row_second_1['user_id'].'" selected>'.$row_second_1['Name'].'</option>';
		while ($row2 = mysqli_fetch_array($r2)) {
			if ($view == 'date') {
				$opt_second_1 .= '<option value="'.$row2['user_id'].'">' . $row2['Name'] . ' ... ' . date('F j, Y', strtotime($row2['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_1 .= '<option value="'.$row2['user_id'].'">' . $row2['Name'] . '</option>';
			}
		}
	} else {
		while ($row2 = mysqli_fetch_array($r2)) {
			if ($view == 'date') {
				$opt_second_1 = '<option value="'.$row2['user_id'].'">' . $row2['Name'] . ' ... ' . date('F j, Y', strtotime($row2['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_1 = '<option value="'.$row2['user_id'].'">' . $row2['Name'] . '</option>';
			}
		}
	}
	if ($num_row_second_1 = 1) {
		$opt_second_1_study = '<option value="'.$row_second_1['study_id'].'" selected>'.$row_second_1['Study'].'</option>';
		while ($row13 = mysqli_fetch_array($r13)) {
			$opt_second_1_study .= '<option value="'.$row13['study_id'].'">'.$row13['Study'].'</option>';
		}
	} else {
		while ($row13 = mysqli_fetch_array($r13)) {
			$opt_second_1_study = '<option value="'.$row13['study_id'].'">'.$row13['Study'].'</option>';
		}
	}
	if ($num_row_second_2 = 1) {
		$opt_second_2 = '<option value="'.$row_second_2['user_id'].'" selected>'.$row_second_2['Name'].'</option>';
		while ($row3 = mysqli_fetch_array($r3)) {
			if ($view == 'date') {
				$opt_second_2 .= '<option value="'.$row3['user_id'].'">' . $row3['Name'] . ' ... ' . date('F j, Y', strtotime($row3['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_2 .= '<option value="'.$row3['user_id'].'">' . $row3['Name'] . '</option>';
			}
		}
	} else {
		while ($row3 = mysqli_fetch_array($r3)) {
			if ($view == 'date') {
				$opt_second_2 = '<option value="'.$row3['user_id'].'">' . $row3['Name'] . ' ... ' . date('F j, Y', strtotime($row3['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_2 = '<option value="'.$row3['user_id'].'">' . $row3['Name'] . '</option>';
			}
		}
	}
	if ($num_row_second_2 = 1) {
		$opt_second_2_study = '<option value="'.$row_second_2['study_id'].'" selected>'.$row_second_2['Study'].'</option>';
		while ($row15 = mysqli_fetch_array($r15)) {
			$opt_second_2_study .= '<option value="'.$row15['study_id'].'">'.$row15['Study'].'</option>';
		}
	} else {
		while ($row15 = mysqli_fetch_array($r15)) {
			$opt_second_2_study = '<option value="'.$row15['study_id'].'">'.$row15['Study'].'</option>';
		}
	}
	if ($num_row_second_2_hh = 1) {
		$opt_second_2_hh =  '<option value="'.$row_second_2_hh['user_id'].'" selected>'.$row_second_2_hh['Name'].'</option>';
		while ($row11 = mysqli_fetch_array($r11)) {
			if ($view == 'date') {
				$opt_second_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . ' ... ' . date('F j, Y', strtotime($row11['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . '</option>';
			}
		}
	} else {
		while ($row11 = mysqli_fetch_array($r11)) {
			if ($view == 'date') {
				$opt_second_2_hh =  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . ' ... ' . date('F j, Y', strtotime($row11['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . '</option>';
			}
		}
	}
	if ($num_row_second_2 = 1) {
		$opt_second_2_setting = '<option value="'.$row_second_2['setting_id'].'" selected>'.$row_second_2['Setting'].'</option>';
		while ($row16 = mysqli_fetch_array($r16)) {
			$opt_second_2_setting .= '<option value="'.$row16['setting_id'].'">'.$row16['Setting'].'</option>';
		}
	} else {
		while ($row16 = mysqli_fetch_array($r16)) {
			$opt_second_2_setting = '<option value="'.$row16['setting_id'].'">'.$row16['Setting'].'</option>';
		}
	}
	if ($num_row_second_3 = 1) {
		$opt_second_3 = '<option value="'.$row_second_3['user_id'].'" selected>'.$row_second_3['Name'].'</option>';
		while ($row4 = mysqli_fetch_array($r4)) {
			if ($view == 'date') {
				$opt_second_3 .= '<option value="'.$row4['user_id'].'">' . $row4['Name'] . ' ... ' . date('F j, Y', strtotime($row4['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_3 .= '<option value="'.$row4['user_id'].'">' . $row4['Name'] . '</option>';
			}
		}
	} else {
		while ($row4 = mysqli_fetch_array($r4)) {
			if ($view == 'date') {
				$opt_second_3 = '<option value="'.$row4['user_id'].'">' . $row4['Name'] . ' ... ' . date('F j, Y', strtotime($row4['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_3 = '<option value="'.$row4['user_id'].'">' . $row4['Name'] . '</option>';
			}
		}
	}
	if ($num_row_second_3 = 1) {
		$opt_second_3_study = '<option value="'.$row_second_3['study_id'].'" selected>'.$row_second_3['Study'].'</option>';
		while ($row17 = mysqli_fetch_array($r17)) {
			$opt_second_3_study .= '<option value="'.$row17['study_id'].'">'.$row17['Study'].'</option>';
		}
	} else {
		while ($row17 = mysqli_fetch_array($r17)) {
			$opt_second_3_study = '<option value="'.$row17['study_id'].'">'.$row17['Study'].'</option>';
		}
	}
	if ($num_row_second_3_hh = 1) {
		$opt_second_3_hh = '<option value="'.$row_second_3_hh['user_id'].'" selected>'.$row_second_3_hh['Name'].'</option>';
		while ($row12 = mysqli_fetch_array($r12)) {
			if ($view == 'date') {
				$opt_second_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . ' ... ' . date('F j, Y', strtotime($row12['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . '</option>';
			}
		}
	} else {
		while ($row12 = mysqli_fetch_array($r12)) {
			if ($view == 'date') {
				$opt_second_3_hh = '<option value="'.$row12['user_id'].'">' . $row12['Name'] . ' ... ' . date('F j, Y', strtotime($row12['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_second_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . '</option>';
			}
		}
	}
	if ($num_row_second_3 = 1) {
			$opt_second_3_setting = '<option value="'.$row_second_3['setting_id'].'" selected>'.$row_second_3['Setting'].'</option>';
			while ($row18 = mysqli_fetch_array($r18)) {
				$opt_second_3_setting .= '<option value="'.$row18['setting_id'].'">'.$row18['Setting'].'</option>';
			}
	} else {
		while ($row18 = mysqli_fetch_array($r18)) {
			$opt_second_3_setting = '<option value="'.$row18['setting_id'].'">'.$row18['Setting'].'</option>';
		}
	}
	// THIRD
	if ($num_row_third_1 = 1) {
		$opt_third_1 = '<option value="'.$row_third_1['user_id'].'" selected>'.$row_third_1['Name'].'</option>';
		while ($row2 = mysqli_fetch_array($r2)) {
			if ($view == 'date') {
				$opt_third_1 .= '<option value="'.$row2['user_id'].'">' . $row2['Name'] . ' ... ' . date('F j, Y', strtotime($row2['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_1 .= '<option value="'.$row2['user_id'].'">' . $row2['Name'] . '</option>';
			}
		}
	} else {
		while ($row2 = mysqli_fetch_array($r2)) {
			if ($view == 'date') {
				$opt_third_1 = '<option value="'.$row2['user_id'].'">' . $row2['Name'] . ' ... ' . date('F j, Y', strtotime($row2['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_1 = '<option value="'.$row2['user_id'].'">' . $row2['Name'] . '</option>';
			}
		}
	}
	if ($num_row_third_1 = 1) {
		$opt_third_1_study = '<option value="'.$row_third_1['study_id'].'" selected>'.$row_third_1['Study'].'</option>';
		while ($row13 = mysqli_fetch_array($r13)) {
			$opt_third_1_study .= '<option value="'.$row13['study_id'].'">'.$row13['Study'].'</option>';
		}
	} else {
		while ($row13 = mysqli_fetch_array($r13)) {
			$opt_third_1_study = '<option value="'.$row13['study_id'].'">'.$row13['Study'].'</option>';
		}
	}
	if ($num_row_third_2 = 1) {
		$opt_third_2 = '<option value="'.$row_third_2['user_id'].'" selected>'.$row_third_2['Name'].'</option>';
		while ($row3 = mysqli_fetch_array($r3)) {
			if ($view == 'date') {
				$opt_third_2 .= '<option value="'.$row3['user_id'].'">' . $row3['Name'] . ' ... ' . date('F j, Y', strtotime($row3['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_2 .= '<option value="'.$row3['user_id'].'">' . $row3['Name'] . '</option>';
			}
		}
	} else {
		while ($row3 = mysqli_fetch_array($r3)) {
			if ($view == 'date') {
				$opt_third_2 = '<option value="'.$row3['user_id'].'">' . $row3['Name'] . ' ... ' . date('F j, Y', strtotime($row3['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_2 = '<option value="'.$row3['user_id'].'">' . $row3['Name'] . '</option>';
			}
		}
	}
	if ($num_row_third_2 = 1) {
		$opt_third_2_study = '<option value="'.$row_third_2['study_id'].'" selected>'.$row_third_2['Study'].'</option>';
		while ($row15 = mysqli_fetch_array($r15)) {
			$opt_third_2_study .= '<option value="'.$row15['study_id'].'">'.$row15['Study'].'</option>';
		}
	} else {
		while ($row15 = mysqli_fetch_array($r15)) {
			$opt_third_2_study = '<option value="'.$row15['study_id'].'">'.$row15['Study'].'</option>';
		}
	}
	if ($num_row_third_2_hh = 1) {
		$opt_third_2_hh =  '<option value="'.$row_third_2_hh['user_id'].'" selected>'.$row_third_2_hh['Name'].'</option>';
		while ($row11 = mysqli_fetch_array($r11)) {
			if ($view == 'date') {
				$opt_third_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . ' ... ' . date('F j, Y', strtotime($row11['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . '</option>';
			}
		}
	} else {
		while ($row11 = mysqli_fetch_array($r11)) {
			if ($view == 'date') {
				$opt_third_2_hh =  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . ' ... ' . date('F j, Y', strtotime($row11['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_2_hh .=  '<option value="'.$row11['user_id'].'">' . $row11['Name'] . '</option>';
			}
		}
	}
	if ($num_row_third_2 = 1) {
		$opt_third_2_setting = '<option value="'.$row_third_2['setting_id'].'" selected>'.$row_third_2['Setting'].'</option>';
		while ($row16 = mysqli_fetch_array($r16)) {
			$opt_third_2_setting .= '<option value="'.$row16['setting_id'].'">'.$row16['Setting'].'</option>';
		}
	} else {
		while ($row16 = mysqli_fetch_array($r16)) {
			$opt_third_2_setting = '<option value="'.$row16['setting_id'].'">'.$row16['Setting'].'</option>';
		}
	}
	if ($num_row_third_3 = 1) {
		$opt_third_3 = '<option value="'.$row_third_3['user_id'].'" selected>'.$row_third_3['Name'].'</option>';
		while ($row4 = mysqli_fetch_array($r4)) {
			if ($view == 'date') {
				$opt_third_3 .= '<option value="'.$row4['user_id'].'">' . $row4['Name'] . ' ... ' . date('F j, Y', strtotime($row4['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_3 .= '<option value="'.$row4['user_id'].'">' . $row4['Name'] . '</option>';
			}
		}
	} else {
		while ($row4 = mysqli_fetch_array($r4)) {
			if ($view == 'date') {
				$opt_third_3 = '<option value="'.$row4['user_id'].'">' . $row4['Name'] . ' ... ' . date('F j, Y', strtotime($row4['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_3 = '<option value="'.$row4['user_id'].'">' . $row4['Name'] . '</option>';
			}
		}
	}
	if ($num_row_third_3 = 1) {
		$opt_third_3_study = '<option value="'.$row_third_3['study_id'].'" selected>'.$row_third_3['Study'].'</option>';
		while ($row17 = mysqli_fetch_array($r17)) {
			$opt_third_3_study .= '<option value="'.$row17['study_id'].'">'.$row17['Study'].'</option>';
		}
	} else {
		while ($row17 = mysqli_fetch_array($r17)) {
			$opt_third_3_study = '<option value="'.$row17['study_id'].'">'.$row17['Study'].'</option>';
		}
	}
	if ($num_row_third_3_hh = 1) {
		$opt_third_3_hh = '<option value="'.$row_third_3_hh['user_id'].'" selected>'.$row_third_3_hh['Name'].'</option>';
		while ($row12 = mysqli_fetch_array($r12)) {
			if ($view == 'date') {
				$opt_third_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . ' ... ' . date('F j, Y', strtotime($row12['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . '</option>';
			}
		}
	} else {
		while ($row12 = mysqli_fetch_array($r12)) {
			if ($view == 'date') {
				$opt_third_3_hh = '<option value="'.$row12['user_id'].'">' . $row12['Name'] . ' ... ' . date('F j, Y', strtotime($row12['Last'])) . '</option>';
			} else if ($view == 'alpha') {
				$opt_third_3_hh .= '<option value="'.$row12['user_id'].'">' . $row12['Name'] . '</option>';
			}
		}
	}
	if ($num_row_third_3 = 1) {
			$opt_third_3_setting = '<option value="'.$row_third_3['setting_id'].'" selected>'.$row_third_3['Setting'].'</option>';
			while ($row18 = mysqli_fetch_array($r18)) {
				$opt_third_3_setting .= '<option value="'.$row18['setting_id'].'">'.$row18['Setting'].'</option>';
			}
	} else {
		while ($row18 = mysqli_fetch_array($r18)) {
			$opt_third_3_setting = '<option value="'.$row18['setting_id'].'">'.$row18['Setting'].'</option>';
		}
	}		
	week_nav ($nav_href, $monday);																				// Week to week navigation	
	include('include/make_tms_slips.php');
	include ('view/form_edit_tms.html');
	week_nav ($nav_href, $monday);																				// Week to week navigation	
	include ('include/footer.html');																				//Include the footer
}
?>