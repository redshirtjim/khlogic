<?php # config.inc.php Jim Rush, Project start date: 10/22/2012

// ******************************************************************************************************** //
// ************************************************** FUNCTIONS ******************************************* //
// ******************************************************************************************************** //

// ***************************************************** //
// **************** schedule() function **************** //
// ***************************************************** //
function schedule () {
	//require_once ('functions_date.php');
	require ('config.inc.php');
	require (MYSQL);
	// ****************** VARIABLES ************************** //	
	$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$page = $_SERVER['REQUEST_URI'];
	$user_id = $_SESSION['user_id'];
	$email = $_SESSION['email'];
	//$method = $_SERVER['REQUEST_METHOD'];
	//$get_monday = $_GET['monday'];
	//$post_monday = $_POST['monday'];
	//$monday =& get_monday_date($method, $get_monday, $post_monday);
	//
	// GET the date for Monday for the PDF view:	
	if ($_SERVER['REQUEST_METHOD'] == 'GET' AND (strpos($host, 'khlogic.org/schedule_pdf.php') !== false) OR (strpos($host, 'khlogic.org/index.php') !== false)) {
		$monday = $_GET['monday'];
	}
	// Determine the date for Monday for initial view:
	if ($host == 'khlogic.org/index.php') { 
		 $weekday = date('N');
		 if ($weekday == 1) {
			 $monday = date('Y-m-d', strtotime('Today'));
		 } else {
			 $monday = date('Y-m-d', strtotime('last Monday'));
		 }
	}
	//POST the date for Monday when a date is selected in the drop down:
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND (strpos($host, 'khlogic.org/index.php') !== false)) {
		$monday = $_POST['monday'];
	}
	//		
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('n/j/y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('n/j/y', strtotime('+6 days', strtotime($monday)));
	$back_arrow = '<h3><a href="index.php?monday=' . date('Y-m-d', strtotime('-7 days', strtotime($monday))) . '"><span class="glyphicon glyphicon-backward"></span></a>';
	$forward_arrow = '<a href="index.php?monday=' . date('Y-m-d', strtotime('+7 days', strtotime($monday))) . '"><span class="glyphicon glyphicon-forward"></span></a></h3>';
	
	// Query and variables for Edit buttons
	$edit_btn_query = "SELECT admin, public, cbs, tms, service_meet, attendants, sound_stage, cleaning, grounds FROM users WHERE user_id = $user_id AND email = '$email'";
	$edit_btn_r = mysqli_query ($dbc, $edit_btn_query) OR die("MySQL errOR: " . mysqli_error($dbc) . "<hr>\nQuery: $edit_btn_query");
	$edit_btn_row = mysqli_fetch_array ($edit_btn_r, MYSQLI_ASSOC);

	$query_school = "SELECT * FROM no_schools WHERE week_of = '$monday'";
	$r_school = mysqli_query ($dbc, $query_school) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\query: $query_school");
	$row_school = mysqli_fetch_array($r_school);
	$no_schools = $row_school['no_schools'];

	if (($edit_btn_row['admin'] != FALSE OR $edit_btn_row['cbs'] != FALSE) AND (strpos($host, 'pdf') == FALSE)) {
		$cbs_edit_btn = '<a href="edit_cbs.php?monday=' . $monday . '"><span class="glyphicon glyphicon-edit"></span></a>';
	} else {
		$cbs_edit_btn = '';
	}
	if (($edit_btn_row['admin'] != FALSE OR $edit_btn_row['tms'] != FALSE) AND (strpos($host, 'pdf') == FALSE)) {
		$tms_edit_btn = '<a href="edit_tms.php?monday=' . $monday . '" ><span class="glyphicon glyphicon-edit"></span></a>';
	} else {
		$tms_edit_btn = '';
	}
	if (($edit_btn_row['admin'] != FALSE OR $edit_btn_row['service_meet'] != FALSE) AND (strpos($host, 'pdf') == FALSE)) {
		$sm_edit_btn = '<a href="edit_servicemeeting.php?monday=' . $monday . '" ><span class="glyphicon glyphicon-edit"></span></a>';
	} else {
		$sm_edit_btn = '';
	}
	if (($edit_btn_row['admin'] != FALSE OR ($edit_btn_row['public'] != FALSE)) AND (strpos($host, 'pdf') == FALSE)) {
		$pm_edit_btn = '<a href="edit_publicmeeting.php?monday=' . $monday . '" ><span class="glyphicon glyphicon-edit"></span></a>';
	} else {
		$pm_edit_btn = '';
	}
	if (($edit_btn_row['admin'] != FALSE OR $edit_btn_row['attendants'] != FALSE) AND (strpos($host, 'pdf') == FALSE)) {
		$att_edit_btn = '<a href="edit_attentents.php?monday=' . $monday . '" ><span class="glyphicon glyphicon-edit"></span></a>';
	} else {
		$att_edit_btn = '';
	}if (($edit_btn_row['admin'] != FALSE OR $edit_btn_row['sound_stage'] != FALSE) AND (strpos($host, 'pdf') == FALSE)) {
		$ss_edit_btn = '<a href="edit_sound.php?monday=' . $monday . '" ><span class="glyphicon glyphicon-edit"></span></a>';
	} else {
		$ss_edit_btn = '';
	}
	if (($edit_btn_row['admin'] != FALSE OR $edit_btn_row['cleaning'] != FALSE) AND (strpos($host, 'pdf') == FALSE)) {
		$khc_edit_btn = '<a href="#" ><span class="glyphicon glyphicon-edit"></span></a>';
	} else {
		$khc_edit_btn = '';
	}
	if (($edit_btn_row['admin'] != FALSE OR $edit_btn_row['grounds'] != FALSE) AND (strpos($host, 'pdf') == FALSE)) {
		$gk_edit_btn = '<a href="#" ><span class="glyphicon glyphicon-edit"></span></a>';
	} else {
		$gk_edit_btn = '';
	}
	// END Query and variables for Edit buttons	
	// ******************END VARIABLES************************** //	
	// ****************** QUERIES **************************** //
	// Database query variables for meeting details (titles of talks, sources material)
	$cts_detail_query = "SELECT * FROM cts_detail WHERE week_of = '$monday'";
	$cts_r = mysqli_query ($dbc, $cts_detail_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\ncts_query: $cts_detail_query");
	while ($cts_row = mysqli_fetch_array($cts_r)) {
		$song_1 = $cts_row['song_1'];
		if (strpos($host, 'khlogic.org/schedule_pdf.php') !== false) {
			$cbs = $cts_row['cbs'];
			$bible_read = $cts_row['bible_read'];
			$no_1 = $cts_row['no_1'];
			$no_2 = $cts_row['no_2'] . ' (' . $cts_row['no_2_source'] . ')';
			$no_3 = $cts_row['no_3'] . ' (' . $cts_row['no_3_source'] . ')';
		} else {
			$cbs = '<a href="' . $cts_row['cbs_url'] . '" target="blank">' . $cts_row['cbs'] . '</a>';
			$bible_read = '<a href="http://wol.jw.org/en/wol/l/r1/lp-e?q=' . $cts_row['bible_read'] . '" target="blank">' . $cts_row['bible_read'] . '</a>';
			$no_1 = '<a href="http://wol.jw.org/en/wol/l/r1/lp-e?q=' . $cts_row['no_1'] . '" target="blank">' . $cts_row['no_1'] . '</a>';
			$no_2 = $cts_row['no_2'] . ' (<a href="' . $cts_row['no_2_url'] . '" target="blank">' . $cts_row['no_2_source'] . '</a>)';
			$no_3 = $cts_row['no_3'] . ' (<a href="' . $cts_row['no_3_url'] . '" target="blank">' . $cts_row['no_3_source'] . '</a>)';
		}
		$song_2 = $cts_row['song_2'];
		$sm_1 = $cts_row['sm_1'];
		$sm_2 = $cts_row['sm_2'];
		$sm_3 = $cts_row['sm_3'];
		$song_3 = $cts_row['song_3'];
	}
	// Database query variables for meeting details (titles of talks, sources material)
	$ptws_query = "SELECT *
		FROM ptws_detail
		WHERE week_of = '$monday'";
	$ptws_r = mysqli_query ($dbc, $ptws_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nptws_query: $ptws_query");
	while ($ptws_row = mysqli_fetch_array($ptws_r)) {
		$ptws_song_1 = $ptws_row[2];
		$ptws_song_2 = $ptws_row[3];
		$wt_study = $ptws_row[6];
		$ptws_song_3 = $ptws_row[4];
	}
	// END Database query variables for meeting details (titles of talks, sources material)
	// assign_record_exists() function determines if an assignment record for a given date already exists. It returns an array including user and assignment information.
	// Database query variables for when assignment record exists. The query returns data from users table and assignments table.
	// overseer query
	$row_overseer =& assign_record_exists($monday, 2, 3); //page_id = 2 AND assign_type_id = 3
	$num_row_overseer = mysqli_num_rows($row_overseer);
	// reader query
	$row_reader =& assign_record_exists($monday, 2, 4); //page_id = 2 AND assign_type_id = 4
	$num_row_reader = mysqli_num_rows($row_reader);
	// open_prayer query
	$row_open_prayer =& assign_record_exists($monday, 2, 5); //page_id = 2 AND assign_type_id = 5
	$num_row_open_prayer = mysqli_num_rows($row_open_prayer);
	// highlights query
	$row_highlights =& assign_record_exists($monday, 3, 7); //page_id = 3 AND assign_type_id = 7
	$num_row_highlights = mysqli_num_rows($row_highlights);
	//Main school queries
	// main_1 query
	$row_main_1 =& assign_record_exists($monday, 3, 8); //page_id = 3 AND assign_type_id = 8
	$num_row_main_1 = mysqli_num_rows($row_main_1);
	// main_2 query
	$row_main_2 =& assign_record_exists($monday, 3, 9); //page_id = 3 AND assign_type_id = 9
	$num_row_main_2 = mysqli_num_rows($row_main_2);
	// main_2 hh query
	$row_main_2_hh =& assign_record_exists($monday, 3, 33); //page_id = 3 AND assign_type_id = 33
	$num_row_main_2_hh = mysqli_num_rows($row_main_2_hh);
	// main_3 query
	$row_main_3 =& assign_record_exists($monday, 3, 10); //page_id = 3 AND assign_type_id = 10
	$num_row_main_3 = mysqli_num_rows($row_main_3);
	// main_3 hh query
	$sister =&is_sister($monday, 10);
	if ($sister == 1) {
		$row_main_3_hh =& assign_record_exists($monday, 3, 34); //page_id = 3 AND assign_type_id = 34
		$num_row_main_3_hh = mysqli_num_rows($row_main_3_hh);
	}
	//END Main school queries	
	// Second school queries
	// second_1 query
	$row_second_1 =& assign_record_exists($monday, 3, 11); //page_id = 3 AND assign_type_id = 11
	$num_row_second_1 = mysqli_num_rows($row_second_1);
	// second_2 query
	$row_second_2 =& assign_record_exists($monday, 3, 12); //page_id = 3 AND assign_type_id = 12
	$num_row_second_2 = mysqli_num_rows($row_second_2);
	// second_2 hh query
	$row_second_2_hh =& assign_record_exists($monday, 3, 35); //page_id = 3 AND assign_type_id = 35
	$num_row_second_2_hh = mysqli_num_rows($row_second_2_hh);
	// second_3 query
	$row_second_3 =& assign_record_exists($monday, 3, 13); //page_id = 3 AND assign_type_id = 13
	$num_row_second_3 = mysqli_num_rows($row_second_3);
	// second_3 hh query
	$sister =&is_sister($monday, 13);
	if ($sister == 1) {
		$row_second_3_hh =& assign_record_exists($monday, 3, 36); //page_id = 3 AND assign_type_id = 36
		$num_row_second_3_hh = mysqli_num_rows($row_second_3_hh);
	}
	//END Second school queries
	//Third school queries
	// third_1 query
	$row_third_1 =& assign_record_exists($monday, 3, 14); //page_id = 3 AND assign_type_id = 14
	$num_row_third_1 = mysqli_num_rows($row_third_1);
	// third_2 query
	$row_third_2 =& assign_record_exists($monday, 3, 15); //page_id = 3 AND assign_type_id = 15
	$num_row_third_2 = mysqli_num_rows($row_third_2);
	// third_2 hh query
	$row_third_2_hh =& assign_record_exists($monday, 3, 37); //page_id = 3 AND assign_type_id = 37
	$num_row_third_2_hh = mysqli_num_rows($row_third_2_hh);
	// third_3 query
	$row_third_3 =& assign_record_exists($monday, 3, 16); //page_id = 3 AND assign_type_id = 16
	$num_row_third_3 = mysqli_num_rows($row_third_3);
	// third_3 hh query
	$sister =&is_sister($monday, 16);
	if ($sister == 1) {
		$row_third_3_hh =& assign_record_exists($monday, 3, 38); //page_id = 3 AND assign_type_id = 38
		$num_row_third_3_hh = mysqli_num_rows($row_third_3_hh);
	}
	//END Third school queries
	// *** END Database query variables for forms select options ***		
	// part_1 query
	$row_part_1 =& assign_record_exists($monday, 4, 17); //page_id = 4 AND assign_type_id = 17
	$num_row_part_1 = mysqli_num_rows($row_part_1);
	// part_2 query
	$row_part_2 =& assign_record_exists($monday, 4, 18); //page_id = 4 AND assign_type_id = 18
	$num_row_part_2 = mysqli_num_rows($row_part_2);
	// part_3 query
	$row_part_3 =& assign_record_exists($monday, 4, 19); //page_id = 4 AND assign_type_id = 19
	$num_row_part_3 = mysqli_num_rows($row_part_3);
	// close_prayer query
	$row_close_prayer =& assign_record_exists($monday, 4, 32); //page_id = 4 AND assign_type_id = 32
	$num_row_close_prayer = mysqli_num_rows($row_close_prayer);
	// attend1_meet1 query
	$row_attend1_meet1 =& assign_record_exists($monday, 5, 30); //page_id = 5 AND assign_type_id = 30
	$num_row_attend1_meet1 = mysqli_num_rows($row_attend1_meet1);
	// attend2_meet1 query
	$row_attend2_meet1 =& assign_record_exists($monday, 5, 31); //page_id = 5 AND assign_type_id = 31
	$num_row_attend2_meet1 = mysqli_num_rows($row_attend2_meet1);
	// sound_meet1 query
	$row_sound_meet1 =& assign_record_exists($monday, 6, 24); //page_id = 6 AND assign_type_id = 24
	$num_row_sound_meet1 = mysqli_num_rows($row_sound_meet1);
	// stage_meet1 query
	$row_stage_meet1 =& assign_record_exists($monday, 6, 25); //page_id = 6 AND assign_type_id = 25
	$num_row_stage_meet1 = mysqli_num_rows($row_stage_meet1);	
	// mic1_meet1 query
	$row_mic1_meet1 =& assign_record_exists($monday, 6, 26); //page_id = 6 AND assign_type_id = 26
	$num_row_mic1_meet1 = mysqli_num_rows($row_mic1_meet1);
	// mic2_meet1 query
	$row_mic2_meet1 =& assign_record_exists($monday, 6, 27); //page_id = 6 AND assign_type_id = 27
	$num_row_mic2_meet1 = mysqli_num_rows($row_mic2_meet1);
	// speaker query
	$row_speaker =& assign_record_exists($monday, 1, 1); //page_id = 1 AND assign_type_id = 1
	$num_row_speaker = mysqli_num_rows($row_speaker);
	if ($row_speaker['user_id'] > 0) {
		$local = 1;
	} else {
		$local = 0;
	}
	$query_talks = "SELECT talk_id, week_of, name, phone, no_hosp, congr_id, theme_id, local_sp, t.theme AS Theme, c.congregation AS Cong
		FROM talks
		INNER JOIN themes AS t
		USING ( theme_id )
		INNER JOIN congregations as c
		USING ( congr_id )
		WHERE week_of = '$monday' AND outgoing = 0";
	$r_talks = mysqli_query ($dbc, $query_talks) OR die("MySQL error_talks: " . mysqli_error($dbc) . "<hr>\nQuery: $query_talks");
	$row_talks = mysqli_fetch_array($r_talks);
	if ($local == 1) {
		$speaker = $row_speaker['Name'];
		$theme = $row_speaker['Theme'];
		$cong = DEF_CONG;
	} else {
		$speaker = $row_talks['name'];
		$theme = $row_talks['Theme'];
		$cong = $row_talks['Cong'];
	}
	// outgoing speaker query
	$row_out_speaker =& assign_record_exists($monday, 1, 6); //page_id = 1 AND assign_type_id = 6
	$num_row_out_speaker = mysqli_num_rows($row_out_speaker);
	$outtheme = $row_out_speaker['theme_id'] . ' ' . $row_out_speaker['Theme'];	
	$outcong = $row_out_speaker['Cong'];
	if ($row_out_speaker['user_id'] > 0) {
		$out_speaker = 1;
	} else {
		$out_speaker = 0;
	}
	// outgoing speaker 2 query
	$row_out_speaker_2 =& assign_record_exists($monday, 1, 39); //page_id = 1 AND assign_type_id = 39
	$num_row_out_speaker_2 = mysqli_num_rows($row_out_speaker_2);
	$outtheme_2 = $row_out_speaker_2['theme_id'] . ' ' . $row_out_speaker_2['Theme'];	
	$outcong_2 = $row_out_speaker_2['Cong'];
	if ($row_out_speaker_2['user_id'] > 0) {
		$out_speaker_2 = 1;
	} else {
		$out_speaker_2 = 0;
	}				
	// outgoing speaker 3 query
	$row_out_speaker_3 =& assign_record_exists($monday, 1, 40); //page_id = 1 AND assign_type_id = 40
	$num_row_out_speaker_3 = mysqli_num_rows($row_out_speaker_3);
	$outtheme_3 = $row_out_speaker_3['theme_id'] . ' ' . $row_out_speaker_3['Theme'];	
	$outcong_3 = $row_out_speaker_3['Cong'];
	if ($row_out_speaker_3['user_id'] > 0) {
		$out_speaker_3 = 1;
	} else {
		$out_speaker_3 = 0;
	}				
	// Chairman query
	$row_chairman =& assign_record_exists($monday, 1, 2); //page_id = 1 AND assign_type_id = 2
	$num_row_chairman = mysqli_num_rows($row_chairman);
	// wtoverseer query
	$row_wtoverseer =& assign_record_exists($monday, 1, 3); //page_id = 1 AND assign_type_id = 3
	$num_row_wtoverseer = mysqli_num_rows($row_wtoverseer);
	// wtreader query
	$row_wtreader =& assign_record_exists($monday, 1, 4); //page_id = 1 AND assign_type_id = 4
	$num_row_wtreader = mysqli_num_rows($row_wtreader);
	// attend1_meet2 query
	$row_attend1_meet2 =& assign_record_exists($monday, 5, 28); //page_id = 5 AND assign_type_id = 28
	$num_row_attend1_meet2 = mysqli_num_rows($row_attend1_meet2);
	// attend2_meet2 query
	$row_attend2_meet2 =& assign_record_exists($monday, 5, 29); //page_id = 5 AND assign_type_id = 29
	$num_row_attend2_meet2 = mysqli_num_rows($row_attend2_meet2);
	// sound_meet2 query
	$row_sound_meet2 =& assign_record_exists($monday, 6, 20); //page_id = 6 AND assign_type_id = 20
	$num_row_sound_meet2 = mysqli_num_rows($row_sound_meet2);
	// stage_meet2 query
	$row_stage_meet2 =& assign_record_exists($monday, 6, 21); //page_id = 6 AND assign_type_id = 21
	$num_row_stage_meet2 = mysqli_num_rows($row_stage_meet2);
	// mic1_meet2 query
	$row_mic1_meet2 =& assign_record_exists($monday, 6, 22); //page_id = 6 AND assign_type_id = 22
	$num_row_mic1_meet2 = mysqli_num_rows($row_mic1_meet2);
	// mic2_meet2 query
	$row_mic2_meet2 =& assign_record_exists($monday, 6, 23); //page_id = 6 AND assign_type_id = 23
	$num_row_mic2_meet2 = mysqli_num_rows($row_mic2_meet2);
	// attend1_meet2 query
	$row_attend1_meet2 =& assign_record_exists($monday, 5, 28); //page_id = 5 AND assign_type_id = 28
	$num_row_attend1_meet2 = mysqli_num_rows($row_attend1_meet2);
	// attend2_meet2 query
	$row_attend2_meet2 =& assign_record_exists($monday, 5, 29); //page_id = 5 AND assign_type_id = 29
	$num_row_attend2_meet2 = mysqli_num_rows($row_attend2_meet2);
	// attend1_meet1 query
	$row_attend1_meet1 =& assign_record_exists($monday, 5, 30); //page_id = 5 AND assign_type_id = 30
	$num_row_attend1_meet1 = mysqli_num_rows($row_attend1_meet1);
	// attend2_meet1 query
	$row_attend2_meet1 =& assign_record_exists($monday, 5, 31); //page_id = 5 AND assign_type_id = 31
	$num_row_attend2_meet1 = mysqli_num_rows($row_attend2_meet1);
	// sister & aux school queries
	$sister1 =&is_sister($monday, 10);
	if ($sister1 == 1) {
			$main_hall_no3 = $row_main_3['Name'] . '<br>' . $row_main_3_hh['Name'];
		} else {
			$main_hall_no3 = $row_main_3['Name'];
		}
	if ($no_schools >= 2) {
		$sister2 =&is_sister($monday, 13);
		if ($sister2 == 1) {
			$sec_hall_no3 = $row_second_3['Name'] . '<br>' . $row_second_3_hh['Name'];
		} else {
			$sec_hall_no3 = $row_second_3['Name'];
		}
		$sec_hall_header = 'Aux School';
		$sec_hall_no1 = $row_second_1['Name'];
		$sec_hall_no2 = $row_second_2['Name'] . '<br>' . $row_second_2_hh['Name'];
		$col_wid_2 = '150';
	}
	if ($no_schools >= 3) {
		$sister =&is_sister($monday, 16);
		if ($sister == 1) {
			$third_hall_no3 = $row_third_3 .  '<br>' . $row_third_3_hh['Name'];
		} else {
			$third_hall_no3 = $row_third_3;
		}
		$third_hall_header = 'Aux School';
		$third_hall_no1 = $row_third_1['Name'];
		$third_hall_no2 = $row_third_2['Name'] . '<br>' . $row_third_2_hh['Name'];
		$col_wid_3 = '150';
	}
	require (CLSMYSQL); // Database connection.
	// ****************** END QUERIES **************************** //
	//$schedule = include ('view/form_schedule.html');
	ob_start();                      // start capturing output
	include('view/form_schedule.html');   // execute the file
	$schedule = ob_get_contents();    // get the contents from the buffer
	ob_end_clean(); 
/*	$schedule .= $back_arrow . $date . $forward_arrow;
	$schedule .= '<h4>Congregation Bible Study (' . $midweek . ')' . $cbs_edit_btn . '</h4>';
	$schedule .= '
		<table><tr>
		<td width="150" valign="top">Opening Prayer:</td><td valign="top">' . $row_open_prayer['Name'] . '</td>
		</tr><tr>
		<td valign="top">Overseer:</td><td valign="top">' . $row_overseer['Name'] . '</td>
		</tr><tr>
		<td valign="top">Reader:</td><td valign="top">' . $row_reader['Name'] . '</td>
		</tr><tr>
		<td valign="top">Material:</td><td valign="top">' . $cbs . '</td>
		</tr></table>';
	$schedule .= '<h4>Theocratic Ministry School (' . $midweek . ')' . $tms_edit_btn . '</h4>';
	$schedule .= '
		<table><tr>
		<td width="120" valign="top">Bible Highlights:</td><td width="150" valign="top">' . $row_highlights['Name'] . '</td>
		<td width="300" valign="top"><i>' . $bible_read . '</i></td>
		</tr></table>';
	//<!-- school form -->
	$schedule .= '<br><table><tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr></table>
		<table class="sched_table" >
		<tr><th width="50" valign="top"></th><th width="150" >MainHall</th><th width="' . $col_wid_2 . '">' . $sec_hall_header . '</th><th width="' . $col_wid_3 . '" >' . $third_hall_header . '</th><th></th></tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 1</td>
		<td valign="top" style="border-top:1px solid black">' . $row_main_1['Name'] . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no1 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_1 . '</i></td>
		</tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 2</td>
		<td valign="top" style="border-top:1px solid black">' . $row_main_2['Name'] . '<br>' . $row_main_2_hh['Name'] . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no2 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_2 . '</i></td>
		</tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 3</td>
		<td valign="top" style="border-top:1px solid black">' . $main_hall_no3 . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no3 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_3 . '</i></td>
		</tr></table>';
	$schedule .= '<h4>Service Meeting (' . $midweek . ')' . $sm_edit_btn . '</h4>';
	$schedule .= '<table><tr>
		<td width="150" valign="top" >' . $row_part_1['Name'] . '</td><td width="500" valign="top" ><i>' . $sm_1 . '</i></td>
		</tr><tr>
		<td valign="top" style="border-top:1px solid black">' . $row_part_2['Name'] . '</td><td valign="top" style="border-top:1px solid black"><i>' . $sm_2 . '</i></td>
		</tr><tr>
		<td valign="top" style="border-top:1px solid black">' . $row_part_3['Name'] . '</td><td valign="top" style="border-top:1px solid black"><i>' . $sm_3 . '</i></td>
		</tr></table>
		<table><tr><td> </td><td> </td></tr></table>
		<table><tr><tr>
		<td width="110" valign="top" >Closing Prayer:</td><td valign="top" >' . $row_close_prayer['Name'] . '</td>
		</tr></table>';
	$schedule .= '<h4>Attendants' . $att_edit_btn . ' / Sound & Stage' . $ss_edit_btn . '(' . $midweek . ')</h4>';
	$schedule .= '<table><tr>
		<td width="80" valign="top">Attendant:</td><td width="125" valign="top">' . $row_attend1_meet1['Name'] . '</td>
		<td width="100" valign="top">Sound Panel:</td><td width="125" valign="top">' . $row_sound_meet1['Name'] . '</td>
		<td width="90" valign="top">Microphone:</td><td width="125" valign="top">' . $row_mic1_meet1['Name'] . '</td>
		</tr><tr>
		<td width="80" valign="top">Attendant:</td><td width="125" valign="top">' . $row_attend2_meet1['Name'] . '</td>
		<td width="100" valign="top">Stage:</td><td width="125" valign="top">' . $row_stage_meet1['Name'] . '</td>
		<td width="90" valign="top">Microphone:</td><td width="125" valign="top">' . $row_mic2_meet1['Name'] . '</td>
		</tr></table><hr>';
	$schedule .= '<h4>Public Meeting (' . $sunday . ')' . $pm_edit_btn . '</h4>';
	$schedule .= '<table><tr>
		<td width="150" valign="top">Chairman:</td><td width="300" valign="top">' . $row_chairman['Name'] . '</td>
		</tr><tr>
		<td valign="top">Public Speaker:</td><td valign="top">' . $speaker . '</td>
		</tr><tr>
		<td valign="top">Congregation:</td><td valign="top">' . $cong . '</td>
		</tr><tr>
		<td valign="top">Talk Theme:</td><td valign="top"><i>' . $theme . '</i></td>
		</tr><tr>
		<td valign="top">Watchtower Reader:</td><td valign="top">' . $row_wtreader['Name'] . '</td>
		</tr><tr>
		<td valign="top">Watchtower Article:</td><td valign="top"><i>' . $wt_study . '</i></td>
		</tr></table>';
		if ($out_speaker == 1) {
			$schedule .= '
			<table><tr>
			<td valign="top" width="150">Outgoing Speaker:</td><td valign="top">' . $row_out_speaker['Name'] . '</td>
			</tr><tr>
			<td valign="top">Congregation:</td><td valign="top">' . $outcong . '</td>
			</tr><tr>
			<td valign="top">Talk Theme:</td><td valign="top"><i>' . $outtheme . '</i></td>
			</tr></table>';
			if ($out_speaker_2 == 1) {
				$schedule .= '
				<table><tr>
				<td valign="top" width="150">Outgoing Speaker:</td><td valign="top">' . $row_out_speaker_2['Name'] . '</td>
				</tr><tr>
				<td valign="top">Congregation:</td><td valign="top">' . $outcong_2 . '</td>
				</tr><tr>
				<td valign="top">Talk Theme:</td><td valign="top"><i>' . $outtheme_2 . '</i></td>
				</tr></table>';
				if ($out_speaker_3 == 1) {
					$schedule .= '
					<table><tr>
					<td valign="top" width="150">Outgoing Speaker:</td><td valign="top">' . $row_out_speaker_3['Name'] . '</td>
					</tr><tr>
					<td valign="top">Congregation:</td><td valign="top">' . $outcong_3 . '</td>
					</tr><tr>
					<td valign="top">Talk Theme:</td><td valign="top"><i>' . $outtheme_3 . '</i></td>
					</tr></table>';
				}
			}
		}
	$schedule .= '<h4>Attendants' . $att_edit_btn . ' / Sound & Stage' . $ss_edit_btn . '(' . $sunday . ')</h4>';
	$schedule .= '<table><tr>
		<td width="80" valign="top">Attendant:</td><td width="125" valign="top">' . $row_attend1_meet2['Name'] . '</td>
		<td width="100" valign="top">Sound Panel:</td><td width="125" valign="top">' . $row_sound_meet2['Name'] . '</td>
		<td width="90" valign="top">Microphone:</td><td width="125" valign="top">' . $row_mic1_meet2['Name'] . '</td>
		</tr><tr>
		<td width="80" valign="top">Attendant:</td><td width="125" valign="top">' . $row_attend2_meet2['Name'] . '</td>
		<td width="100" valign="top">Stage:</td><td width="125" valign="top">' . $row_stage_meet2['Name'] . '</td>
		<td width="90" valign="top">Microphone:</td><td width="125" valign="top">' . $row_mic2_meet2['Name'] . '</td>
		</tr></table><br>';
	require (CLSMYSQL); // Database connection.
	if((strpos($host, 'khlogic.org/index.php') !== false)) {
		$schedule .= '<a href="schedule_pdf.php?monday=' . $monday . '" target="blank"><span class="glyphicon glyphicon-file"></span></a>';
	}*/
	return $schedule;
}
// ***************************************************** //
// ****************END schedule() function************** //
// ***************************************************** //

// ***************************************************** //
// **************** school_worksheet_1() function ****** //
// ***************************************************** //
function &school_worksheet_1() {
	//require_once ('functions_date.php');
	require ('config.inc.php');
	require (MYSQL);
	// ****************** VARIABLES ************************** //	
	$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$page = $_SERVER['REQUEST_URI'];
	$user_id = $_SESSION['user_id'];
	$email = $_SESSION['email'];
	//$method = $_SERVER['REQUEST_METHOD'];
	//$get_monday = $_GET['monday'];
	//$post_monday = $_POST['monday'];
	//$monday =& get_monday_date($method, $get_monday, $post_monday);
	//
	//POST the date for Monday when a date is selected in the drop down:
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND (strpos($host, 'khlogic.org/index.php') !== false)) {
		$monday = $_POST['monday'];
	}
	// GET the date for Monday for the PDF view:	
	if ($_SERVER['REQUEST_METHOD'] == 'GET' AND (strpos($host, 'khlogic.org/schoolworksheet_pdf.php') !== false)) {
		$monday = $_GET['monday'];
	}
	//		
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('n/j/y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('n/j/y', strtotime('+6 days', strtotime($monday)));
	$next_week = date('Y-n-j', strtotime('+7 days', strtotime($monday)));
	// ******************END VARIABLES************************** //	
	// ****************** QUERIES **************************** //
	// Database query variables for meeting details (titles of talks, sources material)
	$cts_detail_query = "SELECT * FROM cts_detail WHERE week_of = '$monday'";
	$cts_r = mysqli_query ($dbc, $cts_detail_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\ncts_query: $cts_detail_query");
	while ($cts_row = mysqli_fetch_array($cts_r)) {
		$song_1 = $cts_row['song_1'];
		$cbs = $cts_row['cbs'];
		$bible_read = $cts_row['bible_read'];
		$no_1 = $cts_row['no_1'];
		$no_2 = $cts_row['no_2'] . ' (' . $cts_row['no_2_source'] . ')';
		$no_3 = $cts_row['no_3'] . ' (' . $cts_row['no_3_source'] . ')';
		$song_2 = $cts_row['song_2'];
		$sm_1 = $cts_row['sm_1'];
		$sm_2 = $cts_row['sm_2'];
		$sm_3 = $cts_row['sm_3'];
		$song_3 = $cts_row['song_3'];
	}
	$next_cts_detail_query = "SELECT * FROM cts_detail WHERE week_of = '$next_week'";
	$next_cts_r = mysqli_query ($dbc, $next_cts_detail_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\ncts_query: $next_cts_detail_query");
	while ($next_cts_row = mysqli_fetch_array($next_cts_r)) {
		$next_bible_read = $next_cts_row['bible_read'];
	}	
	// END Database query variables for meeting details (titles of talks, sources material)
	// assign_record_exists() function determines if an assignment record for a given date already exists. It returns an array including user and assignment information.
	// Database query variables for when assignment record exists. The query returns data from users table and assignments table.
	// overseer query
	$row_overseer =& assign_record_exists($monday, 2, 3); //page_id = 2 AND assign_type_id = 3
	$num_row_overseer = mysqli_num_rows($row_overseer);
	// reader query
	$row_reader =& assign_record_exists($monday, 2, 4); //page_id = 2 AND assign_type_id = 4
	$num_row_reader = mysqli_num_rows($row_reader);
	// open_prayer query
	$row_open_prayer =& assign_record_exists($monday, 2, 5); //page_id = 2 AND assign_type_id = 5
	$num_row_open_prayer = mysqli_num_rows($row_open_prayer);
	// highlights query
	$row_highlights =& assign_record_exists($monday, 3, 7); //page_id = 3 AND assign_type_id = 7
	$num_row_highlights = mysqli_num_rows($row_highlights);
	// next highlights query
	$row_next_highlights =& assign_record_exists($next_week, 3, 7); //page_id = 3 AND assign_type_id = 7
	$num_row_next_highlights = mysqli_num_rows($row_highlights);
	//Main school queries
	// main_1 query
	$row_main_1 =& assign_record_exists($monday, 3, 8); //page_id = 3 AND assign_type_id = 8
	$num_row_main_1 = mysqli_num_rows($row_main_1);
	// main_2 query
	$row_main_2 =& assign_record_exists($monday, 3, 9); //page_id = 3 AND assign_type_id = 9
	$num_row_main_2 = mysqli_num_rows($row_main_2);
	// main_2 hh query
	$row_main_2_hh =& assign_record_exists($monday, 3, 33); //page_id = 3 AND assign_type_id = 33
	$num_row_main_2_hh = mysqli_num_rows($row_main_2_hh);
	// main_3 query
	$row_main_3 =& assign_record_exists($monday, 3, 10); //page_id = 3 AND assign_type_id = 10
	$num_row_main_3 = mysqli_num_rows($row_main_3);
	// main_3 hh query
	$sister =&is_sister($monday, 10);
	if ($sister == 1) {
		$row_main_3_hh =& assign_record_exists($monday, 3, 34); //page_id = 3 AND assign_type_id = 34
		$num_row_main_3_hh = mysqli_num_rows($row_main_3_hh);
	}
	//END Main school queries	
	// Second school queries
	// second_1 query
	$row_second_1 =& assign_record_exists($monday, 3, 11); //page_id = 3 AND assign_type_id = 11
	$num_row_second_1 = mysqli_num_rows($row_second_1);
	// second_2 query
	$row_second_2 =& assign_record_exists($monday, 3, 12); //page_id = 3 AND assign_type_id = 12
	$num_row_second_2 = mysqli_num_rows($row_second_2);
	// second_2 hh query
	$row_second_2_hh =& assign_record_exists($monday, 3, 35); //page_id = 3 AND assign_type_id = 35
	$num_row_second_2_hh = mysqli_num_rows($row_second_2_hh);
	// second_3 query
	$row_second_3 =& assign_record_exists($monday, 3, 13); //page_id = 3 AND assign_type_id = 13
	$num_row_second_3 = mysqli_num_rows($row_second_3);
	// second_3 hh query
	$sister =&is_sister($monday, 13);
	if ($sister == 1) {
		$row_second_3_hh =& assign_record_exists($monday, 3, 36); //page_id = 3 AND assign_type_id = 36
		$num_row_second_3_hh = mysqli_num_rows($row_second_3_hh);
	}
	//END Second school queries
	//Third school queries
	// third_1 query
	$row_third_1 =& assign_record_exists($monday, 3, 14); //page_id = 3 AND assign_type_id = 14
	$num_row_third_1 = mysqli_num_rows($row_third_1);
	// third_2 query
	$row_third_2 =& assign_record_exists($monday, 3, 15); //page_id = 3 AND assign_type_id = 15
	$num_row_third_2 = mysqli_num_rows($row_third_2);
	// third_2 hh query
	$row_third_2_hh =& assign_record_exists($monday, 3, 37); //page_id = 3 AND assign_type_id = 37
	$num_row_third_2_hh = mysqli_num_rows($row_third_2_hh);
	// third_3 query
	$row_third_3 =& assign_record_exists($monday, 3, 16); //page_id = 3 AND assign_type_id = 16
	$num_row_third_3 = mysqli_num_rows($row_third_3);
	// third_3 hh query
	$sister =&is_sister($monday, 16);
	if ($sister == 1) {
		$row_third_3_hh =& assign_record_exists($monday, 3, 38); //page_id = 3 AND assign_type_id = 38
		$num_row_third_3_hh = mysqli_num_rows($row_third_3_hh);
	}
	//END Third school queries
	// *** END Database query variables for forms select options ***		

	// sister & aux school queries
	$sister1 =&is_sister($monday, 10);
	if ($sister1 == 1) {
			$main_hall_no3 = $row_main_3['Name'] . '<br>' . $row_main_3_hh['Name'];
		} else {
			$main_hall_no3 = $row_main_3['Name'];
		}
	if (NUMBER_SCHOOLS >= 2) {
		$sister2 =&is_sister($monday, 13);
		if ($sister2 == 1) {
			$sec_hall_no3 = $row_second_3['Name'] . '<br>' . $row_second_3_hh['Name'];
		} else {
			$sec_hall_no3 = $row_second_3['Name'];
		}
		$sec_hall_header = '2nd Hall';
		$sec_hall_no1 = $row_second_1['Name'];
		$sec_hall_no2 = $row_second_2['Name'] . '<br>' . $row_second_2_hh['Name'];
		$col_wid_2 = '150';
	}
	if (NUMBER_SCHOOLS >= 3) {
		$sister =&is_sister($monday, 16);
		if ($sister == 1) {
			$third_hall_no3 = $row_third_3 .  '<br>' . $row_third_3_hh['Name'];
		} else {
			$third_hall_no3 = $row_third_3;
		}
		$third_hall_header = '3rd Hall';
		$third_hall_no1 = $row_third_1['Name'];
		$third_hall_no2 = $row_third_2['Name'] . '<br>' . $row_third_2_hh['Name'];
		$col_wid_3 = '150';
	}
	// ****************** END QUERIES **************************** //
	$school_worksheet_1 .= '<h1>' . $date . '</h1>';
	$school_worksheet_1 .= '<h4>Main School (' . $midweek . ')' . $tms_edit_btn . '</h4>';
	$school_worksheet_1 .= '<br><table><tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr></table>
		<table class="sched_table" >
		<tr><th width="50" valign="top"></th><th width="150" >MainHall</th><th width="' . $col_wid_2 . '">' . $sec_hall_header . '</th><th width="' . $col_wid_3 . '" >' . $third_hall_header . '</th><th></th></tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 1</td>
		<td valign="top" style="border-top:1px solid black">' . $row_main_1['Name'] . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no1 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_1 . '</i></td>
		</tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 2</td>
		<td valign="top" style="border-top:1px solid black">' . $row_main_2['Name'] . '<br>' . $row_main_2_hh['Name'] . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no2 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_2 . '</i></td>
		</tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 3</td>
		<td valign="top" style="border-top:1px solid black">' . $main_hall_no3 . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no3 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_3 . '</i></td>
		</tr></table>';
	$school_worksheet_1 .= '
		<table><tr>
		<td width="120" valign="top">Bible Highlights Next Week:</td><td width="150" valign="top">' . $row_next_highlights['Name'] . '</td>
		<td width="300" valign="top"><i>' . $next_bible_read . '</i></td>
		</tr></table><div style="page-break-after:always"></div>';		
		
	$school_worksheet_1 .= '<h1>' . $date . '</h1>';
	$school_worksheet_1 .= '<h4>Second School (' . $midweek . ')' . $tms_edit_btn . '</h4>';
	$school_worksheet_1 .= '<br><table><tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr></table>
		<table class="sched_table" >
		<tr><th width="50" valign="top"></th><th width="150" >MainHall</th><th width="' . $col_wid_2 . '">' . $sec_hall_header . '</th><th width="' . $col_wid_3 . '" >' . $third_hall_header . '</th><th></th></tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 1</td>
		<td valign="top" style="border-top:1px solid black">' . $row_main_1['Name'] . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no1 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_1 . '</i></td>
		</tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 2</td>
		<td valign="top" style="border-top:1px solid black">' . $row_main_2['Name'] . '<br>' . $row_main_2_hh['Name'] . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no2 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_2 . '</i></td>
		</tr><tr>
		<td valign="top" style="border-top:1px solid black">No. 3</td>
		<td valign="top" style="border-top:1px solid black">' . $main_hall_no3 . '</td>
		<td valign="top" style="border-top:1px solid black">' . $sec_hall_no3 . '</td>
		<td width="300" valign="top" style="border-top:1px solid black"><i>' . $no_3 . '</i></td>
		</tr></table>';
	$school_worksheet_1 .= '
		<table><tr>
		<td width="120" valign="top">Bible Highlights Next Week:</td><td width="150" valign="top">' . $row_next_highlights['Name'] . '</td>
		<td width="300" valign="top"><i>' . $next_bible_read . '</i></td>
		</tr></table><div style="page-break-after:always"></div>';

	$school_worksheet_1 .= '<h1>' . $date . '</h1>';
	$school_worksheet_1 .= '<h4>Auxilary Council Worksheet (' . $midweek . ')' . $tms_edit_btn . '</h4>';
	$school_worksheet_1 .= '
		<table><tr>
		<td width="120" valign="top">Bible Highlights:</td><td width="150" valign="top">' . $row_highlights['Name'] . '</td>
		<td width="300" valign="top"><i>' . $bible_read . '</i></td>
		</tr></table>';
		
	require (CLSMYSQL); // Database connection.
	if((strpos($host, 'khlogic.org/index.php') !== false)) {
		$school_worksheet_1 .= '<a href="schedule_pdf.php?monday=' . $monday . '" target="blank"><span class="glyphicon glyphicon-file"></span></a>';
	}
	return $school_worksheet_1;
}
// ***************************************************** //
// ************ END school_worksheet_1() function ****** //
// ***************************************************** //

// ***************************************************** //
// **************** handle_post() function ************* //
// ***************************************************** //
function &handle_assignment_post ($monday, $user_id, $meeting_type_id, $assign_type_id, $page_id) {
	require (MYSQL); // Database connection.
	// conflict query and variables
	$query_conflict = "SELECT user_id, meeting_type_id, m.meeting_type AS 'Meeting', assign_type_id, at.assign_friendly_name AS 'Assignment', CONCAT(u.first_name,' ',u.last_name) as 'Name', p.page AS Page
		FROM assignments AS a
		INNER JOIN assignment_type AS at
		USING ( assign_type_id )
		INNER JOIN users AS u
		USING ( user_id )
		INNER JOIN page AS p
		USING ( page_id )
		INNER JOIN meeting_type AS m
		USING ( meeting_type_id )
		WHERE week_of = '$monday' AND meeting_type_id = '$meeting_type_id' AND user_id = '$user_id'";
	$r_conflict = mysqli_query ($dbc, $query_conflict) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query_conflict");
	// END conflict query and variables
	if (mysqli_num_rows($r_conflict) > 0) {
		$conflict_msg = '';
		while ($row_conflict = mysqli_fetch_array($r_conflict)) { // Loop.
			$user_id_in_conflict = $row_conflict['Name'];
			$meeting_id_in_conflict = $row_conflict['Meeting'];
			$page_id_in_conflict = $row_conflict['Page'];
			$assignment_id_in_conflict = $row_conflict['Assignment'];
			if ($row_conflict['assign_type_id'] = '20' OR '21' OR '22' OR '23' OR '24' OR '25' OR '26' OR '27' OR '28' OR '29' OR '30' OR '31') {
				$conflict_msg .= "<b> $user_id_in_conflict has already been assigned - $assignment_id_in_conflict - $meeting_id_in_conflict </b><br>";
			} else {
				$conflict_msg .= "<b> $user_id_in_conflict has already been assigned - $assignment_id_in_conflict - $page_id_in_conflict </b><br>";
			}
		} // END Loop.
		echo '<script type="text/javascript"> alert("' . strip_tags($conflict_msg) . '");</script>';
	}
	$query_assign = "SELECT * FROM assignments WHERE week_of = '$monday' AND assign_type_id = '$assign_type_id' AND page_id = '$page_id'"; // assign type id 1 = Public Speaker; page id 1 = Public Meeting
	$r_assign = mysqli_query ($dbc, $query_assign) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Query: $query_assign");
	// Check if there are more that one record matching the same date, assignment type, and page. This means that more than person has been assigned to the same assignment on the same date and meeting.
	if (mysqli_num_rows($r_assign) == 1) {
		list($assignid) = mysqli_fetch_array ($r_assign, MYSQLI_NUM); 				// If one record returned then that assignment already exists in the table;
	} else if (mysqli_num_rows($r_assign) > 1) { 									// assign it to a variable to be used in the next conditional.
		print 'You have more that one speaker user IDs on the same assignment.'; 	// Or if more that one record exists for the query for some reason, which it shouldn't then print a msg
	}
	// If the assignid variable exists, then the record should be updated with the new selection; otherwise insert a record for the selection.
	if ($assignid) {
	 	$query_update = "UPDATE assignments SET user_id = '$user_id' WHERE assign_id = '$assignid'";
		$r_speaker = mysqli_query ($dbc, $query_update) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query_update");
	} else {
	 	$query_update = "INSERT INTO assignments (week_of, user_id, assign_type_id, page_id, meeting_type_id) VALUES ('$monday', '$user_id', '$assign_type_id', '$page_id', '$meeting_type_id')";
		 $r_speaker = mysqli_query ($dbc, $query_update) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query_update");
	}
	require (CLSMYSQL); // Close the database connection.
	return $conflict_msg;
}
// ***************************************************** //
// ************ END handle_post() function ************* //
// ***************************************************** //

// ***************************************************** //
// ********** handle_cong_theme_post() function ******** //
// ***************************************************** //
function &handle_cong_theme_post($monday, $congr_id, $theme_id, $meeting_type_id, $assign_type_id, $page_id) {
	require (MYSQL); // Database connection.
	$query_find = "SELECT * FROM assignments WHERE week_of = '$monday' AND assign_type_id = '$assign_type_id' AND page_id = '$page_id'"; // assign type id 1 = Public Speaker; page id 1 = Public Meeting
	$r_find = mysqli_query ($dbc, $query_find) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Query: $query_find");
	// Check if there are more that one record matching the same date, assignment type, and page. This means that more than person has been assigned to the same assignment on the same date and meeting.
	if (mysqli_num_rows($r_find) == 1) {
		list($assignid) = mysqli_fetch_array ($r_find, MYSQLI_NUM); 				// If one record returned then that assignment already exists in the table; 
	} else if (mysqli_num_rows($r_find) > 1) { 										// assign it to a variable to be used in the next conditional.
		print 'You have more that one speaker user IDs on the same assignment.'; 	// Or if more that one record exists for the query for some reason, which it shouldn't then print a msg
	}
	// If the assignid variable exists, then the record should be updated with the new selection; otherwise insert a record for the selection.
	if ($assignid) {
	 	$query = "UPDATE assignments SET congr_id = '$congr_id', theme_id = '$theme_id' WHERE assign_id = '$assignid'";
		$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query");
	} else {
	 	$query_update = "INSERT INTO assignments (congr_id, theme_id) VALUES ('$congr_id', '$theme_id')";
	 	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query");
	}
	require (CLSMYSQL); // Close the database connection.
}
// ***************************************************** //
// ****** END handle_cong_theme_post() function ******** //
// ***************************************************** //

// ***************************************************** //
// ********** handle_study_post() function ************* //
// ***************************************************** //
function &handle_study_post($monday, $study_id, $meeting_type_id, $assign_type_id, $page_id) {
	require (MYSQL); // Database connection.
	$query_find = "SELECT * FROM assignments WHERE week_of = '$monday' AND assign_type_id = '$assign_type_id' AND page_id = '$page_id'"; // assign type id 1 = Public Speaker; page id 1 = Public Meeting
	$r_find = mysqli_query ($dbc, $query_find) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Query: $query_find");
	// Check if there are more that one record matching the same date, assignment type, and page. This means that more than person has been assigned to the same assignment on the same date and meeting.
	if (mysqli_num_rows($r_find) == 1) {
		list($assignid) = mysqli_fetch_array ($r_find, MYSQLI_NUM); 				// If one record returned then that assignment already exists in the table; 
	} else if (mysqli_num_rows($r_find) > 1) { 										// assign it to a variable to be used in the next conditional.
		print 'You have more that one speaker user IDs on the same assignment.'; 	// Or if more that one record exists for the query for some reason, which it shouldn't then print a msg
	}
	// If the assignid variable exists, then the record should be updated with the new selection; otherwise insert a record for the selection.
	if ($assignid) {
	 	$query = "UPDATE assignments SET study_id = '$study_id' WHERE assign_id = '$assignid'";
		$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query");
	} else {
	 	$query_update = "INSERT INTO assignments (study_id) VALUES ('$study_id')";
	 	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query");
	}
	require (CLSMYSQL); // Close the database connection.
}
// ***************************************************** //
// ********** END handle_study_post() function ********* //
// ***************************************************** //

// ***************************************************** //
// ********** handle_setting_post() function *********** //
// ***************************************************** //
function &handle_setting_post($monday, $setting_id, $meeting_type_id, $assign_type_id, $page_id) {
	require (MYSQL); // Database connection.
	$query_find = "SELECT * FROM assignments WHERE week_of = '$monday' AND assign_type_id = '$assign_type_id' AND page_id = '$page_id'"; // assign type id 1 = Public Speaker; page id 1 = Public Meeting
	$r_find = mysqli_query ($dbc, $query_find) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Query: $query_find");
	// Check if there are more that one record matching the same date, assignment type, and page. This means that more than person has been assigned to the same assignment on the same date and meeting.
	if (mysqli_num_rows($r_find) == 1) {
		list($assignid) = mysqli_fetch_array ($r_find, MYSQLI_NUM); 		// If one record returned then that assignment already exists in the table; 
	} else if (mysqli_num_rows($r_find) > 1) { 							// assign it to a variable to be used in the next conditional.
		print 'You have more that one speaker user IDs on the same assignment.'; 	// Or if more that one record exists for the query for some reason, which it shouldn't then print a msg
	}
	// If the assignid variable exists, then the record should be updated with the new selection; otherwise insert a record for the selection.
	if ($assignid) {
	 	$query = "UPDATE assignments SET setting_id = '$setting_id' WHERE assign_id = '$assignid'";
		$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query");
	} else {
	 	$query_update = "INSERT INTO assignments (setting_id) VALUES ('$setting_id')";
	 	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query");
	}
	require (CLSMYSQL); // Close the database connection.
}
// ***************************************************** //
// ********** END handle_setting_post() function ******* //
// ***************************************************** //

// ***************************************************** //
// ********** assign_record_exists() function ********** //
// ***************************************************** //
function &assign_record_exists ($monday, $page_id, $assign_type_id) {
	require (MYSQL); // Database connection.
	$query = "SELECT user_id, assign_type_id, at.assignment AS 'Assignment', CONCAT(u.first_name,' ',u.last_name) as 'Name', p.page AS Page, study_id, CONCAT(st.study_id, ' ',st.study) AS 'Study', setting_id, CONCAT(se.setting_id, ' ',se.setting) AS 'Setting', theme_id, th.theme AS Theme, c.congregation AS Cong
		FROM assignments
		INNER JOIN themes AS th
		USING ( theme_id )
		INNER JOIN assignment_type AS at
		USING ( assign_type_id )
		INNER JOIN users AS u
		USING ( user_id )
		INNER JOIN page AS p
		USING ( page_id )
		LEFT JOIN studies AS st
		USING ( study_id )
		LEFT JOIN settings AS se
		USING ( setting_id )
		LEFT JOIN congregations AS c
		USING ( congr_id )
		WHERE week_of = '$monday' AND page_id = '$page_id' AND assign_type_id = '$assign_type_id'";
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	$row = mysqli_fetch_array($r);
	require (CLSMYSQL); // Close the database connection.
	return $row;
}
// ***************************************************** //
// ****** END assign_record_exists() function ********** //
// ***************************************************** //

// ***************************************************** //
// ***************** show_approved() function ********** //
// ***************************************************** //
function &show_approved ($assignment, $assign_type_id) {
	require (MYSQL); // Database connection.
	$query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS Name FROM users WHERE $assignment = 1 ORDER BY last_name";
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	require (CLSMYSQL); // Close the database connection.
	return $r;
}
// ***************************************************** //
// ************* END show_approved() function ********** //
// ***************************************************** //

// ***************************************************** //
// ********** show_approved_bydate() function ********** //
// ***************************************************** //
function &show_approved_bydate ($assignment, $assign_type_id) {
	require (MYSQL); // Database connection.
	$query = "SELECT user_id, CONCAT( u.first_name,  ' ', u.last_name ) AS Name, MAX( week_of ) AS Last
		FROM assignments
		INNER JOIN users AS u
		USING ( user_id ) 
		WHERE $assignment = 1
		AND assign_type_id = $assign_type_id
		GROUP BY Name
		ORDER BY Last";
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	require (CLSMYSQL); // Close the database connection.
	return $r;
}
// ***************************************************** //
// ********** END show_approved_bydate() function ****** //
// ***************************************************** //

// ***************************************************** //
// ********** study() function ************************* //
// ***************************************************** //
function &study () {
	require (MYSQL); // Database connection.
	$query = "SELECT study_id, CONCAT(study_id, ' ', study) AS Study FROM studies ORDER BY study_id";
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	require (CLSMYSQL); // Close the database connection.
	return $r;
}
// ***************************************************** //
// ********** END study() function ********************* //
// ***************************************************** //

// ***************************************************** //
// ********** setting() function ************************* //
// ***************************************************** //
function &setting () {
	require (MYSQL); // Database connection.
	$query = "SELECT setting_id, CONCAT(setting_id, ' ', setting) AS Setting FROM settings ORDER BY setting_id";
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	require (CLSMYSQL); // Close the database connection.
	return $r;
}
// ***************************************************** //
// ********** END setting() function ******************* //
// ***************************************************** //

// ***************************************************** //
// ********** is_sister() function ********************* //
// ***************************************************** //
function &is_sister ($monday, $assign_type_id) {
	require (MYSQL); // Database connection.
	$query = "SELECT user_id, assign_type_id, u.gender
	FROM assignments AS a
	INNER JOIN users AS u
	USING ( user_id )
	WHERE week_of = '$monday' AND u.gender = 'Sr.' AND assign_type_id = '$assign_type_id'";
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	if (mysqli_num_rows($r) > 0) {
		$sister = 1;
	} else {
		$sister = 0;
	}
	require (CLSMYSQL); // Close the database connection.
	return $sister;
}
// ***************************************************** //
// ********** END is_sister() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** my_assignments() function **************** //
// ***************************************************** //
function my_assignments() {
	require (MYSQL); // Database connection.
	$email = $_SESSION['email'];
	$user_id = $_SESSION['user_id'];
	$name = $_SESSION['first_name'].' '.$_SESSION['last_name'];
	$msg .= '<br><p><b>Assigment(s) for '.$name.':</b></p><br>';
	$query = "SELECT 
		week_of, 
		m.meeting_type AS Meeting, 
		at.assign_friendly_name AS 'Assignment', 
		c.cbs AS 'Cbs', 
		c.cbs_url AS 'Cbs_url',
		c.bible_read AS 'Bible_read', 
		c.no_1 AS 'No_1', 
		c.no_2 AS 'No_2', 
		c.no_2_source AS 'No_2_source', 
		c.no_2_url AS 'No_2_url', 
		c.no_3 AS 'No_3', 
		c.no_3_source AS 'No_3_source', 
		c.no_3_url AS 'No_3_url', 
		c.sm_1 AS 'Sm_1', 
		c.sm_2 AS 'Sm_2', 
		c.sm_3 AS 'Sm_3', 
		w.theme AS 'Theme_detail', 
		w.wt_study AS 'Article', 
		p.page AS 'Page', 
		p.page_id AS 'Page_id', 
		theme_id AS'Theme_id', 
		th.theme AS 'Theme', 
		n.congregation AS 'Congregation'
		FROM assignments
		LEFT JOIN themes AS th
		USING ( theme_id ) 
		LEFT JOIN congregations AS n
		USING ( congr_id ) 
		LEFT JOIN assignment_type AS at
		USING ( assign_type_id ) 
		LEFT JOIN users AS u
		USING ( user_id ) 
		LEFT JOIN meeting_type AS m
		USING ( meeting_type_id ) 
		LEFT JOIN page AS p
		USING ( page_id ) 
		LEFT JOIN cts_detail AS c
		USING ( week_of ) 
		LEFT JOIN ptws_detail AS w
		USING ( week_of ) 
		WHERE user_id =  '$user_id'
		AND week_of >= DATE_SUB( CURDATE( ) , INTERVAL 6 
		DAY ) 
		ORDER BY week_of, p.page_id";
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	$week_cat = '';//A control variable
	while ($row = mysqli_fetch_array($r)) {
		$week = $row['week_of'];
		$date = date('F j, Y', strtotime($week));
		$meeting = $row['Meeting'];
		$assign = $row['Assignment'];
		$cbs = $row['Cbs'];
		$cbs_url = $row['Cbs_url'];
		$bible_read = trim(strip_tags($row['Bible_read']));
		$no_1 = trim(strip_tags($row['No_1']));
		$no_2 = $row['No_2'];
		$no_2_source = $row['No_2_source'];
		$no_2_url = $row['No_2_url'];
		$no_3 = $row['No_3'];
		$no_3_source = $row['No_3_source'];
		$no_3_url = $row['No_3_url'];
		$sm_1 = $row['Sm_1'];
		$sm_2 = $row['Sm_2'];
		$sm_3 = $row['Sm_3'];
		$theme_detail = $row['Theme_detail'];
		$article = $row['Article'];
		$page = $row['Page'];
		$page_id = $row['Page_id'];
		$theme_id = $row['Theme_id'];
		$theme = $row['Theme'];
		$congregation = $row['Congregation'];
	    if($week != $week_cat) {		    //if its a new week date group, then start a new <ul>
	        if($week_cat != '') {		    //If it is not the first occurance of the same week, close previous one
		        $msg .= "</ul>\n";
	        }
	        $msg .= '<b>' . $date . '</b>';
	        $msg .= '<ul>';
	    }
	    // create the assignment items in a table after each week date group
		$msg .= '<table><tr>';
		if ($assign == 'Sound Panel' OR $assign == 'Stage' OR $assign == 'Microphone' OR $assign == 'Attendant') {
			$msg .= '<td valign="top">' . $meeting . ': </td>';
			$msg .= '<td valign="top">' . $assign . '</td>';
		} else {
			$msg .= '<td valign="top"><b>' . $page . ': </b></td>';
			$msg .= '<td valign="top"><b>' . $assign . '</b></td>';
		}
		if ($assign == 'Reader' AND $meeting == 'Congregation Bible Study') {
			$assign_detail = '<a href="' . $cbs_url . '" target="_blank">' . $cbs . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Bible highlights') {
			$assign_detail = '<a href="http://wol.jw.org/en/wol/l/r1/lp-e?q=' . $bible_read . '">' . $bible_read . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Talk No. 1') {
			$assign_detail = '<a href="http://wol.jw.org/en/wol/l/r1/lp-e?q=' . $no_1 . '">' . $no_1 . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Talk No. 2') {
			$assign_detail = '<a href="' . $no_2_url . '" target="_blank">' . $no_2 . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
			$query = "SELECT CONCAT(u.first_name,' ',u.last_name) as 'Name', u.phone_1 AS Phone, st.study AS Study, se.setting AS Setting
			FROM assignments AS a
			INNER JOIN users AS u
			USING ( user_id )
			LEFT JOIN studies as st
			USING ( study_id )
			LEFT JOIN settings as se
			USING ( setting_id )
			WHERE week_of = '$week' AND assign_type_id = 33";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			$row = mysqli_fetch_array($r);
			$query1 = "SELECT CONCAT(st.study_id, ' ', st.study) AS Study, CONCAT(se.setting_id, ' ', se.setting) AS Setting
			FROM assignments AS a
			LEFT JOIN studies as st
			USING ( study_id )
			LEFT JOIN settings as se
			USING ( setting_id )
			WHERE week_of = '$week' AND assign_type_id = 9";
			$r1 = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row1 = mysqli_fetch_array($r1);			
			$num = mysqli_num_rows($r1);
			if ($num > 0) {
				$speaker = $row1['Name'];
				$phone = $row1['Phone'];
				$study = $row1['Study'];
				$setting = $row1['Setting'];
				$msg .= '<tr><td></td><td></td><td valign="top">Assistant: ' . $speaker . ' ' . $phone . '</td></tr>';
				$msg .= '<tr><td></td><td></td><td valign="top">Study: ' . $study . '</td></tr>';
				$msg .= '<tr><td></td><td></td><td valign="top">Setting: ' . $setting . '</td></tr>';
			}
		}
		if ($assign == 'No. 2 Householder') {
			$assign_detail = $no_2;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
			$query = "SELECT CONCAT(u.first_name,' ',u.last_name) as 'Name', u.phone_1 AS Phone
			FROM assignments AS a
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week' AND assign_type_id = 9";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			$row = mysqli_fetch_array($r);
			$num = mysqli_num_rows($r);
			if ($num > 0) {
				$speaker = $row['Name'];
				$phone = $row['Phone'];
				$msg .= '<tr><td></td><td></td><td valign="top">Your speaker: ' . $speaker . ' ' . $phone . '</td></tr>';
			}
		}
		if ($assign == 'Talk No. 3') {
			$assign_detail = '<a href="' . $no_3_url . '" target="_blank">' . $no_3 . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
			$query = "SELECT CONCAT(u.first_name,' ',u.last_name) as 'Name', u.phone_1 AS Phone, st.study AS Study, se.setting AS Setting
			FROM assignments AS a
			INNER JOIN users AS u
			USING ( user_id )
			LEFT JOIN studies as st
			USING ( study_id )
			LEFT JOIN settings as se
			USING ( setting_id )
			WHERE week_of = '$week' AND assign_type_id = 34";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			$row = mysqli_fetch_array($r);
			$query1 = "SELECT CONCAT(st.study_id, ' ', st.study) AS Study, CONCAT(se.setting_id, ' ', se.setting) AS Setting
			FROM assignments AS a
			LEFT JOIN studies as st
			USING ( study_id )
			LEFT JOIN settings as se
			USING ( setting_id )
			WHERE week_of = '$week' AND assign_type_id = 10";
			$r = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row = mysqli_fetch_array($r);			
			$num = mysqli_num_rows($r);
			if ($num > 0) {
				$speaker = $row['Name'];
				$phone = $row['Phone'];
				$study = $row['Study'];
				$setting = $row['Setting'];
				$msg .= '<tr><td></td><td></td><td valign="top">Your householder: </td><td>' . $speaker . '</td><td>' . $phone . '</td></tr>';
				$msg .= '<tr><td></td><td></td><td valign="top">Study: ' . $study . '</td></tr>';
				$msg .= '<tr><td></td><td></td><td valign="top">Setting: ' . $setting . '</td></tr>';
			}
		}
		if ($assign == 'No. 3 Householder') {
			$assign_detail = $no_3;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
			$query = "SELECT CONCAT(u.first_name,' ',u.last_name) as 'Name', u.phone_1 AS Phone
			FROM assignments AS a
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week' AND assign_type_id = 10";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			$row = mysqli_fetch_array($r);
			$num = mysqli_num_rows($r);
			if ($num > 0) {
				$speaker = $row['Name'];
				$phone = $row['Phone'];
				$msg .= '<tr><td></td><td></td><td valign="top">Your speaker: ' . $speaker . ' ' . $phone . '</td></tr>';
			}
		}	
		if ($assign == 'No. 1') {
			$assign_detail = $sm_1;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'No. 2') {
			$assign_detail = $sm_2;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'No. 3') {
			$assign_detail = $sm_3;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Public Speaker') {
			$assign_detail = $theme;
			$cong = $congregation;
			$talk_no = $theme_id;
			$msg .= '<td valign="top"><b>- ' . $cong . ' Cong.,</b></td>';
			$msg .= '<td valign="top"><b> #' . $talk_no . '</b></td>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Outgoing Speaker') {
			$assign_detail = $theme;
			$cong = $congregation;
			$talk_no = $theme_id;
			$msg .= '<td valign="top"><b>- ' . $cong . ' Cong.,</b></td>';
			$msg .= '<td valign="top"><b> #' . $talk_no . '</b></td>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Reader' AND $meeting == 'Public Meeting') {
			$assign_detail = $article;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}	
		$msg .= '</tr></table>';
		$week_cat = $week;		//Assign the value of actual category for the next time in the loop
	}
$msg .= "</ul>\n";
return $msg;
}
// ***************************************************** //
// ********** END my_assignments() function ************ //
// ***************************************************** //

// ******************************************************************************************************** //
// ********************************************** END FUNCTIONS ******************************************* //
// ******************************************************************************************************** //