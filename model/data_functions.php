<?php # functions_data.php
/*
Jim Rush, 10/22/2012
KHLogic is an application designed to eliminate or reduce scheduling conflicts as multiple schedulers simultaneously give assignments and responsibilities to people in the same resource pool.
It is designed to coordinate all the activities involved in the weekly meetings at a Kingdom Hall. It is to be used by individuals responsible for scheduling and assigning responsibilities for the Public Meeting, Watchtower Study, Congregation Bible Study, Theocratic Ministry School, and Service Meeting, as well as meeting attendants, stage attendant, sound panel attendant, microphone attendants, facility cleaning, and grounds keeping.
The goal is to eliminate or reduce the potential for individuals to be scheduled for conflicting assignments and responsibilities.
*/
// ************ FUNCTIONS ************ //
// ****************************************** //


function who_can_edit($user_id, $email) {
	require ('include/config.inc.php');
	require (MYSQL);
	$edit_btn_query = "SELECT admin, public, cbs, tms, service_meet, attendants, sound_stage, cleaning, grounds FROM users WHERE user_id = $user_id AND email = '$email'";
	$edit_btn_r = mysqli_query ($dbc, $edit_btn_query) OR die("MySQL errOR: " . mysqli_error($dbc) . "<hr>\nQuery: $edit_btn_query");
	$edit_btn_row = mysqli_fetch_array ($edit_btn_r, MYSQLI_ASSOC);
	require (CLOSE_MYSQL);
	return $edit_btn_row;
}
/*
// assign_record_exists() function. Determine if an assignment record exists for a given week date and assignment type.
function &assign_record_exists ($monday, $page_id, $assign_type_id) {
	require ('include/config.inc.php');
	require (MYSQL);	
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
	require (CLOSE_MYSQL); // Close the database connection.
	return $row;
}
// END assign_record_exists() function.
*/
// ***************************************************** //
// ********** user_auth() function ********************* //
// ***************************************************** //
function &user_auth($user_id, $email, $meeting) {
	require (MYSQL); // Database connection.
	$query = "SELECT admin, $meeting FROM users WHERE user_id = $user_id AND email = '$email'";		// Determine the TRUE (1) or FALSE (0) value for the admin & public fields of users table
	$r = mysqli_query ($dbc, $query) OR die("MySQL security check error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	$user_auth = 1;
	if ($row['$meeting'] != TRUE AND $row['admin'] != TRUE) {										// If neither public nor admin is TRUE (1), the user is redirected to index
		$user_auth = 0;
	}
	require (CLSMYSQL); // Close the database connection.
	return $user_auth;
}
// ***************************************************** //
// ********** END user_auth() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** admin_auth() function ********************* //
// ***************************************************** //
function &admin_auth($user_id, $email) {
	require (MYSQL); // Database connection.
	$query = "SELECT admin FROM users WHERE user_id = $user_id AND email = '$email'";			// Determine the TRUE (1) or FALSE (0) value for the admin & public fields of users table
	$r = mysqli_query ($dbc, $query) OR die("MySQL security check error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	$admin_auth = 1;
	if ($row['admin'] != TRUE) {																// If neither public nor admin is TRUE (1), the user is redirected to index
		$admin_auth = 0;
	}
	require (CLSMYSQL); // Close the database connection.
	return $admin_auth;
}
// ***************************************************** //
// ********** END admin_auth() function ***************** //
// ***************************************************** //

function &cts_detail($monday) {
	require (MYSQL);																		// Database connection
	$cts_detail_query = "SELECT * FROM cts_detail WHERE week_of = '$monday'";				// Database query variables for meeting details (titles of talks, sources material)
	$cts_r = mysqli_query ($dbc, $cts_detail_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\ncts_query: $cts_detail_query");
	require (CLSMYSQL); 																	// Close the database connection.
	return $cts_r;
}

// ***************************************************** //
// ********** add_person() function ********************* //
// ***************************************************** //
function &add_person($gender, $f_name, $l_name, $email, $phone1, $phone2, $pub_type_id, $servant_type_id, $public_speaker, $chairman, $reader, $overseer, $prayer, $bible_high, $no_1, $no_2, $no_3, $serv_meet, $attend, $sound_panel, $stage, $mic, $grounds_keeper, $householder) {
	require (MYSQL); // Database connection.
	$pub_insert_query = "INSERT INTO users (gender, first_name, last_name, email, registration_date, phone_1, phone_2, pub_type_id, servant_type_id, public_speaker, chairman, reader, overseer, prayer, bible_high, no_1, no_2, no_3, serv_meet, attend, sound_panel, stage, mic, grounds_keeper, householder) VALUES ('$gender', '$f_name', '$l_name', '$email', NOW(), '$phone1', '$phone2', '$pub_type_id', '$servant_type_id', '$public_speaker', '$chairman', '$reader', '$overseer', '$prayer', '$bible_high', '$no_1', '$no_2', '$no_3', '$serv_meet', '$attend', '$sound_panel', '$stage', '$mic', '$grounds_keeper', '$householder')";
	if (@mysqli_query($dbc, $pub_insert_query)) {													// Execute the query:
		$add_person_reply = 1;
	} else {
		$add_person_reply = 0;
	}
	require (CLSMYSQL); 																			// Close the database connection.
	return $add_person_reply;
}
// ***************************************************** //
// ********** END add_person() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** change_password() function ********************* //
// ***************************************************** //
function &change_password($p, $user_id) {
	$success = 0;
	require (MYSQL); 																				// Database connection.
	$q = "UPDATE users SET passw=SHA1('$p') WHERE user_id=$user_id LIMIT 1";	
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	if (mysqli_affected_rows($dbc) == 1) { 															// If it ran OK.
		$success = 1;
	}
	require (CLSMYSQL); 																			// Close the database connection.
	return $success;
}
// ***************************************************** //
// ********** END add_person() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** display_person() function ********************* //
// ***************************************************** //
function &display_person($user_id) {
	require (MYSQL); // Database connection.
	$query = "SELECT user_id, p.gender, p.last_name, p.first_name, p.pub_type_id, p.servant_type_id, pt.pub_type AS 'Publisher Type', st.servant_type AS 'Servant Type', p.email, p.send_email, p.phone_1, p.phone_2, public_speaker, chairman, reader, overseer, prayer, bible_high, no_1, no_2, no_3, serv_meet, attend, sound_panel, stage, mic, grounds_keeper, householder
		FROM users AS p 
		INNER JOIN servant_type AS st 
		USING ( servant_type_id ) 
		INNER JOIN pub_type AS pt 
		USING ( pub_type_id ) 
		WHERE user_id=$user_id";
	if ($r = mysqli_query($dbc, $query)) {															// Run the query
		$row = mysqli_fetch_array($r);
	}
	require (CLSMYSQL); 																			// Close the database connection.
	return $row;
}
// ***************************************************** //
// ********** END display_person() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** people_search() function ********************* //
// ***************************************************** //
function &people_search($searchstring) {
	require (MYSQL); 																				// Database connection.
	$query = "SELECT user_id, p.last_name AS 'Last Name', p.first_name, CONCAT(p.gender,' ',p.first_name) AS 'First Name', pt.pub_type AS  'Publisher Type', st.servant_type AS  'Servant Type', p.email AS Email, p.phone_1, p.phone_2
		FROM users AS p
		INNER JOIN servant_type AS st
		USING ( servant_type_id ) 
		INNER JOIN pub_type AS pt
		USING ( pub_type_id )
		WHERE p.last_name LIKE '%$searchstring%' OR p.first_name LIKE '%$searchstring%' ORDER BY last_name, first_name";
		$r = mysqli_query ($dbc, $query) or die(mysqli_error());
	require (CLSMYSQL); 																			// Close the database connection.
	return $r;
}
// ***************************************************** //
// ********** END people_search() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** count_people() function ********************* //
// ***************************************************** //
function &count_people($searchstring) {
	require (MYSQL); 																				// Database connection.
	$sql = "SELECT COUNT(user_id) FROM users";
	$query = mysqli_query($dbc, $sql);
	$row = mysqli_fetch_row($query);
	$count = $row[0];																				// Here we have the total row count
	require (CLSMYSQL); 																			// Close the database connection.
	return $count;
}
// ***************************************************** //
// ********** END count_people() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** all_people() function ********************* //
// ***************************************************** //
function &all_people($limit) {
	require (MYSQL); 																				// Database connection.
	$sql = "SELECT user_id, p.last_name AS 'Last Name', CONCAT(p.gender,' ',p.first_name) AS 'First Name', pt.pub_type AS  'Publisher Type', st.servant_type AS  'Servant Type', p.email AS Email, p.phone_1, p.phone_2
		FROM users AS p
		INNER JOIN servant_type AS st
		USING ( servant_type_id ) 
		INNER JOIN pub_type AS pt
		USING ( pub_type_id )
		ORDER BY last_name, first_name $limit";
	$people = mysqli_query($dbc, $sql);
	require (CLSMYSQL); 																			// Close the database connection.
	return $people;
}
// ***************************************************** //
// ********** END all_people() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** delete_person() function ********************* //
// ***************************************************** //
function &delete_person($user_id) {
	require (MYSQL); 																				// Database connection.
	$q = "DELETE FROM users WHERE user_id=$user_id LIMIT 1";											// Make the query
	$r = @mysqli_query ($dbc, $q);
	require (CLSMYSQL); 																			// Close the database connection.
	return $r;
}
// ***************************************************** //
// ********** END delete_person() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** get_name() function ********************* //
// ***************************************************** //
function &get_name($user_id) {
	require (MYSQL); 																				// Database connection.
	$q = "SELECT CONCAT(first_name,' ',last_name) FROM users WHERE user_id=$user_id";					// Retrieve the user's information
	$r = @mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) == 1) {																	// Valid user ID, show the form
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);													// Get the user's information
		$name = $row[0];
	} else {
		$name = FALSE;
	}
	require (CLSMYSQL); 																			// Close the database connection.
	return $name;
}
// ***************************************************** //
// ********** END get_name() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** write_details() function ********************* //
// ***************************************************** //
function &write_details($monday, $song_1, $cbs, $cbs_url, $bible_read, $no_1, $no_2, $no_2_source, $no_2_url, $no_3, $no_3_source, $no_3_url, $song_2, $sm_1, $sm_2, $sm_3, $song_3, $ptws_song_1, $ptws_song_2, $wt_study, $ptws_song_3) {
	require (MYSQL); 																				// Database connection.
	$cts_detail_query = "SELECT * FROM cts_detail WHERE week_of = '$monday'";
	$cts_r = mysqli_query ($dbc, $cts_detail_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\cts_query: $cts_detail_query");
	$ptws_detail_query = "SELECT * FROM ptws_detail WHERE week_of = '$monday'";
	$ptws_r = mysqli_query ($dbc, $ptws_detail_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\ptws_query: $ptws_detail_query");
	if (mysqli_num_rows($cts_r) == 1) {															// If one record returned then that assignment already exists in the table; assign it to a variable to be used in the next conditional
		list($ctsid) = mysqli_fetch_array ($cts_r, MYSQLI_NUM);
	} else if (mysqli_num_rows($cts_r) > 1) {													// Or if more that one record exists for the query for some reason, which it shouldn't then echo a msg
		$details_msg = 'You have more that one cts detail record for this date.'; 	
	}
	if (mysqli_num_rows($ptws_r) == 1) {														// If one record returned then that assignment already exists in the table; assign it to a variable to be used in the next conditional
		list($ptwsid) = mysqli_fetch_array ($ptws_r, MYSQLI_NUM);
	} else if (mysqli_num_rows($cts_r) > 1) {													// Or if more that one record exists for the query for some reason, which it shouldn't then echo a msg
		$details_msg = 'You have more that one ptws detail record for this date.';
	}
	if ($ctsid) {																				// Define the UPDATE queries
		$cts_query = "UPDATE cts_detail SET song_1 = '$song_1', song_2 = '$song_2', song_3 = '$song_3', cbs = '$cbs', cbs_url = '$cbs_url', bible_read = '$bible_read', no_1 = '$no_1', no_2 = '$no_2', no_2_source = '$no_2_source', no_2_url = '$no_2_url', no_3 = '$no_3', no_3_source = '$no_3_source', no_3_url = '$no_3_url', sm_1 = '$sm_1', sm_2 = '$sm_2', sm_3 = '$sm_3' WHERE week_of = '$monday'";	
	} else {																					// Define the INSERT queries
		$cts_query = "INSERT INTO cts_detail (week_of, song_1, song_2, song_3, cbs, cbs_url, bible_read, no_1, no_2, no_2_source, no_2_url, no_3, no_3_source, no_3_url, sm_1, sm_2, sm_3) VALUES ('$monday', '$song_1', '$song_2', '$song_3', '$cbs', '$cbs_url', '$bible_read', '$no_1', '$no_2', '$no_2_source', '$no_2_url', '$no_3', '$no_3_source', '$no_3_url', '$sm_1', '$sm_2', '$sm_3')";
	}
	if ($ptwsid) {																				// Define the UPDATE queries
		$ptws_query = "UPDATE ptws_detail SET ptws_song_1 = '$ptws_song_1', ptws_song_2 = '$ptws_song_2', ptws_song_3 = '$ptws_song_3', wt_study = '$wt_study' WHERE week_of = '$monday'";
	} else {																					// Define the INSERT queries
		$ptws_query = "INSERT INTO ptws_detail (week_of, ptws_song_1, ptws_song_2, ptws_song_3, wt_study) VALUES ('$monday', '$ptws_song_1', '$ptws_song_2', '$ptws_song_3', '$wt_study')";
	}			
	if (@mysqli_query($dbc, $cts_query) AND @mysqli_query($dbc, $ptws_query)) {
		$details_msg = "<p>Details have been added/editted for $date.</p>";
	} else {
		$details_msg = '<p style="color: red;">Could not add the entry because:<br />' . mysqli_error($dbc) . '.</p><p>The queries being run were: ' . $cts_query . ' and ' . $ptws_query  .'</p>';
	}		
	require (CLSMYSQL); 																			// Close the database connection.
	return $details_msg;
}
// ***************************************************** //
// ********** END write_details() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** ptws_detail() function ********************* //
// ***************************************************** //
function &ptws_detail() {
	require (MYSQL); 																				// Database connection.
	$ptws_query = "SELECT * FROM ptws_detail WHERE week_of = '$monday'";
	$ptws_r = mysqli_query ($dbc, $ptws_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nptws_query: $ptws_query");
	$ptws_row = mysqli_fetch_array($ptws_r);
	require (CLSMYSQL); 																			// Close the database connection.
	return $ptws_r;
}
// ***************************************************** //
// ********** END ptws_detail() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** no_schools() function ********************* //
// ***************************************************** //
function &no_schools($monday, $no_schools) {
	require (MYSQL); 																				// Database connection.
	$query = "SELECT * FROM no_schools WHERE week_of = '$monday'";
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Query: $query");
	if (mysqli_num_rows($r) == 1) {
		list($assignid) = mysqli_fetch_array ($r, MYSQLI_NUM); 					// If one record returned then that assignment already exists in the table;
	} else if (mysqli_num_rows($r) > 1) { 												// assign it to a variable to be used in the next conditional.
		$no_schools_msg = 'You have more that one record for this week date.';			// Or if more that one record exists for the query for some reason, which it shouldn't then print a msg
	}
	if ($assignid) {
	 	$query_update = "UPDATE no_schools SET no_schools = '$no_schools' WHERE no_schools_id = '$assignid'";
		$r = mysqli_query ($dbc, $query_update) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query_update");
	} else {
	 	$query_insert = "INSERT INTO no_schools (week_of, no_schools) VALUES ('$monday', '$no_schools')";
		 $r = mysqli_query ($dbc, $query_insert) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nSpeaker_Update_Query: $query_insert");
	}
	require (CLSMYSQL); 																			// Close the database connection.
	return $no_schools_msg;
}
// ***************************************************** //
// ********** END no_schools() function ***************** //
// ***************************************************** //

// ***************************************************** //
// ********** no_schools_assigned() function ********************* //
// ***************************************************** //
function &no_schools_assigned($monday) {
	require (MYSQL); 																				// Database connection.
	$query_school = "SELECT * FROM no_schools WHERE week_of = '$monday'";
	$r_school = mysqli_query ($dbc, $query_school) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\query: $query_school");
	$row_school = mysqli_fetch_array($r_school);
	require (CLSMYSQL); 																			// Close the database connection.
	return $row_school;
}
// ***************************************************** //
// ********** END no_schools_assigned() function ***************** //
// ***************************************************** //


?>