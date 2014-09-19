<?php // edit_pub.php 
/* This script edits a publisher entry. */

session_start();

//Include the header:
require ('include/config.inc.php');

include('include/header.html');

// Connect and select:
require (MYSQL);

if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) ) { // Display the entry in a form:

	// Define the query.
	$query = "SELECT user_id, p.gender, p.last_name, p.first_name, p.pub_type_id, p.servant_type_id, pt.pub_type AS 'Publisher Type', st.servant_type AS 'Servant Type', p.email, p.send_email, p.phone_1, p.phone_2, public_speaker, chairman, reader, overseer, prayer, bible_high, no_1, no_2, no_3, serv_meet, attend, sound_panel, stage, mic, grounds_keeper, householder
		FROM users AS p 
		INNER JOIN servant_type AS st 
		USING ( servant_type_id ) 
		INNER JOIN pub_type AS pt 
		USING ( pub_type_id ) 
		WHERE user_id={$_GET['user_id']}";
	if ($r = mysqli_query($dbc, $query)) { // Run the query.
			
		$row = mysqli_fetch_array($r); // Retrieve the information.
		
		// Assign values 1 or 0 to variable to be used in checkbox values in form
		$send_email_checked = $row['send_email'];
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
				
		// Make the form:
	print '<form action="edit_person.php" method="post">
	<p>First name: <input type="text" name="f_name" size="30" maxsize="30" value="' . htmlentities($row['first_name']) . '" /></p>
	<p>Last name: <input type="text" name="l_name" size="30" maxsize="30" value="' . htmlentities($row['last_name']) . '" /></p>
	<p>E-mail: <input type="text" name="email" size="30" maxsize="30" value="' . htmlentities($row['email']) . '" /></p>';
?>	
	<input type="checkbox" name="send_email" value="1"<?php if ($send_email_checked == 1) echo 'checked'; ?>/> Send assignment E-mails to user?
<?php
	print '
	<p>Phone 1: <input type="text" name="phone_1" size="30" maxsize="30" value="' . htmlentities($row['phone_1']) . '" /></p>
	<p>Phone 2: <input type="text" name="phone_2" size="30" maxsize="30" value="' . htmlentities($row['phone_2']) . '" /></p>
	<p>Publisher Type: <select name="pub_type">
			<option name="pub_type" value="' . htmlentities($row['pub_type_id']) . '">' . htmlentities($row['Publisher Type']) . '</option>
			<option name="pub_type" value="1">Pioneer publisher</option>
			<option name="pub_type" value="2">Baptized publisher</option>
			<option name="pub_type" value="3">Unbaptized publisher</option>
			<option name="pub_type" value="4">Inactive publisher</option>
			</select>
			<p>
	<p>Servant Type: <select name="serv_type">
			<option name="serv_type" value="' . htmlentities($row['servant_type_id']) . '">' . htmlentities($row['Servant Type']) . '</option>
			<option name="serv_type" value="1">Elder</option>
			<option name="serv_type" value="2">Ministerial Servant</option>
			<option name="serv_type" value="3">N/A</option>
			</select>
			<p>';
	?>
		<table>
		<tr>
		<td><input type="checkbox" name="public_speaker" value="1" <?php if ($public_speaker_checked == 1) echo 'checked'; ?>/> Public Speaker</td>
		</tr><tr>
		<td><input type="checkbox" name="chairman" value="1" <?php if ($chairman_checked == 1) echo 'checked'; ?>/> Chairman</td>
		</tr><tr>
		<td><input type="checkbox" name="reader" value="1" <?php if ($reader_checked == 1) echo 'checked'; ?>/> Reader</td>
		</tr><tr>
		<td><input type="checkbox" name="overseer" value="1" <?php if ($overseer_checked == 1) echo 'checked'; ?>/> Overseer</td>
		</tr><tr>
		<td><input type="checkbox" name="prayer" value="1" <?php if ($prayer_checked == 1) echo 'checked'; ?>/> Prayer</td>
		</tr><tr>
		<td><input type="checkbox" name="bible_high" value="1" <?php if ($bible_high_checked == 1) echo 'checked'; ?>/> Bible Highlights</td>
		</tr><tr>
		<td><input type="checkbox" name="no_1" value="1" <?php if ($no_1_checked == 1) echo 'checked'; ?>/> Number 1 Talk</td>
		</tr><tr>
		<td><input type="checkbox" name="no_2" value="1" <?php if ($no_2_checked == 1) echo 'checked'; ?>/> Number 2 Talk</td>
		</tr><tr>
		<td><input type="checkbox" name="no_3" value="1" <?php if ($no_3_checked == 1) echo 'checked'; ?>/> Number 3 Talk</td>
		</tr><tr>
		<td><input type="checkbox" name="householder" value="1" <?php if ($householder_checked == 1) echo 'checked'; ?>/> Householder</td>
		</tr><tr>
		<td><input type="checkbox" name="serv_meet" value="1" <?php if ($serv_meet_checked == 1) echo 'checked'; ?>/> Service Meeting Talks</td>
		</tr><tr>
		<td><input type="checkbox" name="attend" value="1" <?php if ($attend_checked == 1) echo 'checked'; ?>/> Attendant</td>
		</tr><tr>
		<td><input type="checkbox" name="sound_panel" value="1" <?php if ($sound_panel_checked == 1) echo 'checked'; ?>/> Sound Panel</td>
		</tr><tr>
		<td><input type="checkbox" name="stage" value="1" <?php if ($stage_checked == 1) echo 'checked'; ?>/> Stage</td>
		</tr><tr>
		<td><input type="checkbox" name="mic" value="1" <?php if ($mic_checked == 1) echo 'checked'; ?>/> Microphone</td>
		</tr><tr>
		<td><input type="checkbox" name="grounds_keeper" value="1" <?php if ($grounds_keeper_checked == 1) echo 'checked'; ?>/> Grounds Keeper</td>
		</tr>
		</table>	
	<?php
	print '
	<input type="hidden" name="id" value="' . $_GET['user_id'] . '" />
	<input type="submit" name="submit" value=" Submit " />
	</form>';

	} else { // Couldn't get the information.
		print '<p style="color: red;">Could not retrieve the publisher entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
	}

} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) { // Handle the form.

	// Validate and secure the form data:
	$problem = FALSE;
	if (!empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['email']) && !empty($_POST['pub_type'])) {
		$f_name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['f_name'])));
		$l_name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['l_name'])));
		$email = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['email'])));
		$phone_1 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['phone_1'])));
		$phone_2 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['phone_2'])));
		$pub_type = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['pub_type'])));
		$serv_type = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['serv_type'])));
		if (isset($_POST['send_email'])){$send_email=1;} else {$send_email=0;};
		if (isset($_POST['public_speaker'])){$public_speaker=1;} else {$public_speaker=0;};
		if (isset($_POST['chairman'])){$chairman=1;} else {$chairman=0;};
		if (isset($_POST['reader'])){$reader=1;} else {$reader=0;};
		if (isset($_POST['overseer'])){$overseer=1;} else {$overseer=0;};
		if (isset($_POST['prayer'])){$prayer=1;} else {$prayer=0;};
		if (isset($_POST['bible_high'])){$bible_high=1;} else {$bible_high=0;};
		if (isset($_POST['no_1'])){$no_1=1;} else {$no_1=0;};
		if (isset($_POST['no_2'])){$no_2=1;} else {$no_2=0;};
		if (isset($_POST['no_3'])){$no_3=1;} else {$no_3=0;};
		if (isset($_POST['serv_meet'])){$serv_meet=1;} else {$serv_meet=0;};
		if (isset($_POST['attend'])){$attend=1;} else {$attend=0;};
		if (isset($_POST['sound_panel'])){$sound_panel=1;} else {$sound_panel=0;};
		if (isset($_POST['stage'])){$stage=1;} else {$stage=0;};
		if (isset($_POST['mic'])){$mic=1;} else {$mic=0;};
		if (isset($_POST['grounds_keeper'])){$grounds_keeper=1;} else {$grounds_keeper=0;};
		if (isset($_POST['householder'])){$householder=1;} else {$householder=0;};
	} else {
		print '<p style="color: red;">Please submit both a title and an entry.</p>';
		$problem = TRUE;
	}

	if (!$problem) {

		// Define the query.
		$query = "UPDATE users SET first_name='$f_name', last_name='$l_name', email='$email', send_email='$send_email', phone_1='$phone_1', phone_2='$phone_2', pub_type_id='$pub_type', servant_type_id='$serv_type', public_speaker='$public_speaker', chairman='$chairman', reader='$reader', overseer='$overseer', prayer='$prayer', bible_high='$bible_high', no_1='$no_1', no_2='$no_2', no_3='$no_3', serv_meet='$serv_meet', attend='$attend', sound_panel='$sound_panel', stage='$stage', mic='$mic', grounds_keeper='$grounds_keeper', householder='$householder' WHERE user_id={$_POST['id']}";
		$r = mysqli_query($dbc, $query); // Execute the query.
		
		// Report on the result:
		if (mysqli_affected_rows($dbc) == 1 or mysqli_affected_rows($dbc) == 0) {
			require ('include/login_functions.inc.php');
			$user_id = $_POST['id'];
			$page = "display_person.php?user_id=$user_id";
			redirect_user($page);
			} else {
			print '<p style="color: red;">Could not update the entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
		}
		
	} // No problem!

} else { // No ID set.
	print '<p style="color: red;">This page has been accessed in error.</p>';
} // End of main IF.

// Close the connection.
Include('db_close.php');

//Include the footer:
include('include/footer.html');
?>
