<?php // display_person.php This script displays properties of a publisher record.
session_start();
require ('include/config.inc.php');
require ('model/data_functions.php');
include ('include/header.html');																	//Include the header
if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) ) {										// Display the entry in a form
	$user_id = $_GET['user_id'];
	$ok = '<span class="glyphicon glyphicon-ok"></span>';
	$ban_circle = '<span class="glyphicon glyphicon-ban-circle"></span>';
	$row =& display_person($user_id);																// Retrieve the information
	$user_id = $row['user_id'];
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];
	$phone1 = $row['phone_1'];
	$publisher_type = $row['Publisher Type'];
	$servant_type = $row['Servant Type'];
	$send_email_checked = $row['send_email'];														// Assign values from database (1 or 0) to variable to be used in checkbox values in form
	$public_speaker_checked = $row['public_speaker'];
	$chairman_checked = $row['chairman'];
	$reader_checked = $row['reader'];
	$overseer_checked = $row['overseer'];
	$prayer_checked = $row['prayer'];
	$bible_high_checked = $row['bible_high'];
	$no_1_checked = $row['no_1'];
	$no_2_checked = $row['no_2'];
	$no_3_checked = $row['no_3'];
	$serv_meet_checked = $row['serv_meet'];
	$attend_checked = $row['attend'];
	$sound_panel_checked = $row['sound_panel'];
	$stage_checked = $row['stage'];
	$mic_checked = $row['mic'];
	$grounds_keeper_checked = $row['grounds_keeper'];
	$householder_checked = $row['householder'];
	if ($send_email_checked == 1) {
		$mail = $ok;
	} else {
		$mail = $ban_circle;
	}
	include ('view/form_display_person.html');														// Make the form
} else {																							// Couldn't get the information.
		echo '<p style="color: red;">Could not retrieve the publisher entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
}
include('include/footer.html');																		//Include the footer
?>
