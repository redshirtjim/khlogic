<?php // edit_person.php This script edits a publisher entry.
session_start();
require ('include/config.inc.php');
include('include/header.html');																	//Include the header
require (MYSQL);																				// Connect and select
if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) ) {									// Display the entry in a form
	$ok = '<span class="glyphicon glyphicon-ok"></span>';
	$ban_circle = '<span class="glyphicon glyphicon-ban-circle"></span>';
																								// Define the query
	$query = "SELECT user_id, p.gender, p.last_name, p.first_name, p.pub_type_id, p.servant_type_id, pt.pub_type AS 'Publisher Type', st.servant_type AS 'Servant Type', p.email, p.send_email, p.phone_1, p.phone_2, public_speaker, chairman, reader, overseer, prayer, bible_high, no_1, no_2, no_3, serv_meet, attend, sound_panel, stage, mic, grounds_keeper, householder
		FROM users AS p 
		INNER JOIN servant_type AS st 
		USING ( servant_type_id ) 
		INNER JOIN pub_type AS pt 
		USING ( pub_type_id ) 
		WHERE user_id={$_GET['user_id']}";
	if ($r = mysqli_query($dbc, $query)) {														// Run the query
		$row = mysqli_fetch_array($r);															// Retrieve the information
		$send_email_checked = $row['send_email'];												// Assign values 1 or 0 to variable to be used in checkbox values in form
		if ($send_email_checked == 1) {
			$mail = $ok;
			} else {
				$mail = $ban_circle;
			}
																								// Make the form
	print '
	<br><a href=edit_your_user_settings.php?user_id=' . $row['user_id'] . '><span class="glyphicon glyphicon-edit"></span></a> Edit<br>
	<form action="edit_your_user_settings.php" method="post">
	<table>
	<tr><td>First name: </td><td>' . htmlentities($row['first_name']) . '</td></tr>
	<tr><td>Last name: </td><td>' . htmlentities($row['last_name']) . '</td></tr>
	<tr><td>Phone: </td><td>' . htmlentities($row['phone_1']) . '</td></tr>
	<tr><td>E-mail: </td><td>' . htmlentities($row['email']) . $mail . 'Send assignment E-mail</td></tr>
	</table>
	<input type="hidden" name="id" value="' . $_GET['user_id'] . '" />
	</form>
	<a href="change_password.php"><button type="button" class="btn btn-primary">Change Password</button></a></p>';
	} else { // Couldn't get the information
		echo '<p style="color: red;">Could not retrieve the publisher entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
	}
}
require (CLSMYSQL);																				// Close the database connection
include('include/footer.html');																	//Include the footer
?>