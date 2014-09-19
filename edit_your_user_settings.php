<?php // edit_your_user_settings.php This script edits a publisher entry.
session_start();
require ('include/config.inc.php');
include('include/header.html');															//Include the header	
require (MYSQL);																		// Connect and select
$email_check = '';
if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) ) {							// Display the entry in a form
																						// Define the query
	$query = "SELECT user_id, p.gender, p.last_name, p.first_name, p.pub_type_id, p.servant_type_id, pt.pub_type AS 'Publisher Type', st.servant_type AS 'Servant Type', p.email, p.send_email, p.phone_1, p.phone_2, public_speaker, chairman, reader, overseer, prayer, bible_high, no_1, no_2, no_3, serv_meet, attend, sound_panel, stage, mic, grounds_keeper, householder
		FROM users AS p 
		INNER JOIN servant_type AS st 
		USING ( servant_type_id ) 
		INNER JOIN pub_type AS pt 
		USING ( pub_type_id ) 
		WHERE user_id={$_GET['user_id']}";
	if ($r = mysqli_query($dbc, $query)) {												// Run the query
		$row = mysqli_fetch_array($r);													// Retrieve the information
		$send_email_checked = $row['send_email'];										// Assign values 1 or 0 to variable to be used in checkbox values in form
		if ($send_email_checked == 1) {
			$email_check = 'checked';
		}																				// Make the form:
	echo '
	<form action="edit_your_user_settings.php" method="post">
	<table>
	<tr><td>First name: </td><td><input type="text" name="f_name" size="30" maxsize="30" value="' . htmlentities($row['first_name']) . '" /></td></tr>
	<tr><td>Last name: </td><td><input type="text" name="l_name" size="30" maxsize="30" value="' . htmlentities($row['last_name']) . '" /></td></tr>
	<tr><td>Phone: </td><td><input type="text" name="phone_1" size="30" maxsize="30" value="' . htmlentities($row['phone_1']) . '" /></td></tr>
	<tr><td>E-mail: </td><td><input type="text" name="email" size="30" maxsize="30" value="' . htmlentities($row['email']) . '" /></td></tr>
	<tr><td></td><td>E-mail is your username for the KHLogic.org.<br>It is also used to E-mail your assignments.</td></tr>
	<tr><td></td>
	<td valign="top"><input type="checkbox" name="send_email" value="1" ' . $email_check . ' /> Send assignment E-mails to you?
	</td></tr>
	</table>
	<input type="hidden" name="id" value="' . $_GET['user_id'] . '" />
	<input class="btn btn-default" type="submit" name="submit" value=" Submit " />
	</form>';
	} else {																			// Couldn't get the information
		echo '<p style="color: red;">Could not retrieve the publisher entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
	}
} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {							// Handle the form
	$problem = FALSE;																	// Validate and secure the form data
	if (!empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['email'])) {
		$f_name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['f_name'])));
		$l_name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['l_name'])));
		$email = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['email'])));
		$phone_1 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['phone_1'])));
		$phone_2 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['phone_2'])));
		if (isset($_POST['send_email'])){$send_email=1;} else {$send_email=0;};
	} else {
		echo '<p style="color: red;">Please submit first name, last name, and E-mail address.</p>';
		$problem = TRUE;
	}
	if (!$problem) {
																						// Define the query
		$query = "UPDATE users SET first_name='$f_name', last_name='$l_name', email='$email', send_email='$send_email', phone_1='$phone_1', phone_2='$phone_2' WHERE user_id={$_POST['id']}";
		$r = mysqli_query($dbc, $query);												// Execute the query
		if (mysqli_affected_rows($dbc) == 1 or mysqli_affected_rows($dbc) == 0) {		// Report on the result
			require ('include/functions.inc.php');
			$user_id = $_POST['id'];
			$page = "your_user_settings.php?user_id=$user_id";
			redirect_user($page);
			} else {
			echo '<p style="color: red;">Could not update the entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
		}
	}																					// No problem!
} else {																				// No ID set
	echo '<p style="color: red;">This page has been accessed in error.</p>';
}																						// End of main IF
echo '<a href="change_password.php"><button type="button" class="btn btn-primary">Change Password</button></a></p>';
require (CLSMYSQL);																		// Close the connection
include('include/footer.html');															//Include the footer
?>