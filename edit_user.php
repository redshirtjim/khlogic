<?php // edit_user.php 
/* This script edits a user entry. */

session_start();

//Include the header:
//require ('include/config.inc.php');

include('include/header.html');

// Connect and select:
require (MYSQL);

if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) ) { // Display the entry in a form:

	// Define the query.
	$query = "SELECT * FROM users WHERE user_id={$_GET['user_id']}";
	if ($r = mysqli_query($dbc, $query)) { // Run the query.
	
		$row = mysqli_fetch_array($r); // Retrieve the information.

		// Assign values 1 or 0 to variable to be used in checkbox values in form
		$public_checked = $row['public'];
		$cbs_checked = $row['cbs'];
		$tms_checked = $row['tms'];
		$service_meet_checked = $row['service_meet'];
		$attendants_checked = $row['attendants'];
		$sound_stage_checked = $row['sound_stage'];
		$cleaning_checked = $row['cleaning'];
		$grounds_checked = $row['grounds'];
		$admin_checked = $row['admin'];
		
		// Make the form:
		print '<form action="edit_user.php" method="post">
		<table>
		<tr>
		<td>' . htmlentities($row['first_name']) . ' ' . htmlentities($row['last_name']) . '</td>
		</tr>
		</table>';
?>
		<table>
		<tr>
		<td>Check which schedule page(s) this scheduler can see:</td>
		</tr><tr>
		<td><input type="checkbox" name="admin" value="1" <?php if ($admin_checked == 1) echo 'checked'; ?>/> Admin</td>
		</tr><tr>
		<td><input type="checkbox" name="public" value="1" <?php if ($public_checked == 1) echo 'checked'; ?>/> Public Meeting</td>
		</tr><tr>
		<td><input type="checkbox" name="cbs" value="1" <?php if ($cbs_checked == 1) echo 'checked'; ?>/> Congregation Bible Study</td>
		</tr><tr>
		<td><input type="checkbox" name="tms" value="1" <?php if ($tms_checked == 1) echo 'checked'; ?>/> Theocratic Ministry School</td>
		</tr><tr>
		<td><input type="checkbox" name="service_meet" value="1" <?php if ($service_meet_checked == 1) echo 'checked'; ?>/> Service Meeting</td>
		</tr><tr>
		<td><input type="checkbox" name="attendants" value="1" <?php if ($attendants_checked == 1) echo 'checked'; ?>/> Attendants</td>
		</tr><tr>
		<td><input type="checkbox" name="sound_stage" value="1" <?php if ($sound_stage_checked == 1) echo 'checked'; ?>/> Sound & Stage</td>
		</tr><tr>
		<td><input type="checkbox" name="cleaning" value="1" <?php if ($cleaning_checked == 1) echo 'checked'; ?>/> KH Cleaning</td>
		</tr><tr>
		<td><input type="checkbox" name="grounds" value="1" <?php if ($grounds_checked == 1) echo 'checked'; ?>/> Grounds Keeping</td>
		</tr>
		</table>
<?php
	print 
	'<input type="hidden" name="id" value="' . $_GET['user_id'] . '" />
	<input type="submit" name="submit" value=" Submit " />
	</form>';

	} else { // Couldn't get the information.
		print '<p style="color: red;">Could not retrieve the publisher entry because:<br />' . mysql_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
	}

} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) { // Handle the form.

	// Validate and secure the form data:
	$problem = FALSE;
		if (isset($_POST['public'])){$public=1;} else {$public=0;};
		if (isset($_POST['cbs'])){$cbs=1;} else {$cbs=0;};
		if (isset($_POST['tms'])){$tms=1;} else {$tms=0;};
		if (isset($_POST['service_meet'])){$service_meet=1;} else {$service_meet=0;};
		if (isset($_POST['attendants'])){$attendants=1;} else {$attendants=0;};
		if (isset($_POST['sound_stage'])){$sound_stage=1;} else {$sound_stage=0;};
		if (isset($_POST['cleaning'])){$cleaning=1;} else {$cleaning=0;};
		if (isset($_POST['grounds'])){$grounds=1;} else {$grounds=0;};
		if (isset($_POST['admin'])){$admin=1;} else {$admin=0;};

	if (!$problem) {

		// Define the query.
		$query = "UPDATE users SET public='$public', cbs='$cbs', tms='$tms', service_meet='$service_meet', attendants='$attendants', sound_stage='$sound_stage', cleaning='$cleaning', grounds='$grounds', admin='$admin' WHERE user_id={$_POST['id']}";
		$r = mysqli_query($dbc, $query); // Execute the query.
		
		// Report on the result:
		if (mysqli_affected_rows($dbc) == 1 or mysqli_affected_rows($dbc) == 0) {
			print '<p>The publisher has been updated.</p>';
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
