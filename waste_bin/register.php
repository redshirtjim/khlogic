<?php // Script 8.9 - register.php
/* This page lets people register for the site (in theory). */
require ('include/config.inc.php');
// Set the page title and include the header file:
define('TITLE', 'Register - KHLogic');
include('include/generic_header.html');
	print '<h2>Registration Form</h2>';
	// print '<p>Register - There will be 3 types of users: standard users who can view schedules; administrators who can create and schedule publishers; and super administrator who can create and schedule publishers and create administrators.</p>';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require (MYSQL); // Connect to the db.
	
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$first_name = $last_name = $email = $passw = FALSE;
		
	$emailrrors = array(); // Initialize an error array.
	
	// Check for a first name:
	$gender = mysqli_real_escape_string ($dbc, $trimmed['gender']); //Don't need to validate this value 'cause it's chosen from a drop down menu.

	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$first_name = mysqli_real_escape_string ($dbc, $trimmed['first_name']);
	} else {
		echo '<p class="error">Please enter your first name!</p>';
	}
	
	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$last_name = mysqli_real_escape_string ($dbc, $trimmed['last_name']);
	} else {
		echo '<p class="error">Please enter your last name!</p>';
	}
	
	// Check for an email address:
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
		$email = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		echo '<p class="error">Please enter a valid email address!</p>';
	}
	// Check for phone 1:
	if (empty($_POST['phone_1'])) {
		$emailrrors[] = 'You forgot to enter your Phone 1.';
	} else {
		$phone_1 = mysqli_real_escape_string($dbc, trim($_POST['phone_1']));
		$phone_2 = mysqli_real_escape_string($dbc, trim($_POST['phone_2']));
	}
	// Check for a password and match against the confirmed password:
	if (preg_match ('/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $trimmed['pass1']) ) { //Regular expression checks that the password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit.
		if ($trimmed['pass1'] == $trimmed['pass2']) {
			$passw = mysqli_real_escape_string ($dbc, $trimmed['pass1']);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password! The password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit</p>';
	}
	
	if ($first_name && $last_name && $email && $passw) { // If everything's OK.
	
		// Register the user in the database...

		//Make sure email address is not already used:
				$equery = "SELECT user_id FROM users WHERE email='$email'";
		$dup = mysqli_query ($dbc, $equery) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($dup) == 0) { // Available.

			// Create the activation code:
			$a = md5(uniqid(rand(), true));

			// Add the user to the database:
			$query = "INSERT INTO users (gender, first_name, last_name, email, passw, active, registration_date, phone_1, phone_2, admin, public, cbs, tms, service_meet, attendants, sound_stage, cleaning, grounds) VALUES ('$gender', '$first_name', '$last_name', '$email', SHA1('$passw'), '$a', NOW(), '$phone_1', '$phone_2', '0', '0', '0', '0', '0', '0', '0', '0', '0')";

			$r = mysqli_query ($dbc, $query) or trigger_error("Query: $query\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Send the email:
				$to = $trimmed['email'];
				$subject = 'KHLogic Registration';
				$body = "$first_name $last_name,<br>Thank you for registering at KHLogic. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($email) . "&y=$a";
				$headers = "From: rush.jim@gmail.com";
				mail($to, $subject, $body, $headers);

				// Send email to the admin
				$admin_to = 'jimrush72@gmail.com';
				$admin_subject = 'KHLogic User Registration';
				$admin_body = "$first_name $last_name, registered; please think about giving some permissions.\n\n";
				$admin_body .= BASE_URL . 'activate.php?x=' . urlencode($email) . "&y=$a";
				$admin_headers = "From: rush.jim@gmail.com";
				mail($admin_to, $admin_subject, $admin_body, $admin_headers);
								
				// Finish the page:
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account. If you will have responsibility for scheduling assignments, please contact the administrator for permissions.</h3>';
				print '<a href="http://khlogic.org/">Login</a></p>';	
				include ('include/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.	

				} else { // If it did not run OK.
				echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}
			
		} else { // The email address is not available.
			echo '<p class="error">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
		}
		
	} else { // If one of the data tests failed.
		echo '<p class="error">Please try again.</p>';
	}


	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<form action="register.php" method="post">

	<table>
	<tr>
			<td><p class="form">Br/Sr:</p></td>
			<td>
			<select name="gender">
			<option name="gender" value="Select">--</option>
			<option name="gender" value="Br.">Br.</option>
			<option name="gender" value="Sr.">Sr.</option>
			</select>
			</td>
			</tr>
	<tr>
	<td><p class="form">First Name:</p></td>
	<td><input type="text" name="first_name" size="25" value="<?php if (isset($trimmed['first_name'])) { print htmlspecialchars($trimmed['first_name']); } ?>" /></td>
	</tr>
	<tr>
	<td><p class="form">Last Name:</p></td>
	<td><input type="text" name="last_name" size="25" value="<?php if (isset($trimmed['last_name'])) { print htmlspecialchars($trimmed['last_name']); } ?>" /></td>
	</tr>
	<tr>
	<td><p class="form">Email Address:</p></td>
	<td><input type="email" name="email" size="25" value="<?php if (isset($trimmed['email'])) { print htmlspecialchars($trimmed['email']); } ?>" /></td>
	</tr>
	<tr>
	<td><p class="form">Phone 1:</p></td>
	<td><input type="text" name="phone_1" size="25" value="<?php if (isset($trimmed['phone_1'])) { print htmlspecialchars($trimmed['phone_1']); } ?>" /></td>
	</tr>
	<tr>
	<td><p class="form">Phone 2:</p></td>
	<td><input type="text" name="phone_2" size="25" value="<?php if (isset($trimmed['phone_2'])) { print htmlspecialchars($trimmed['phone_2']); } ?>" /></td>
	</tr>
	<tr>
	<td><p class="form">Password:</p></td>
	<td><input type="password" name="pass1" size="25" value="<?php if (isset($trimmed['pass1'])) { print htmlspecialchars($trimmed['pass1']); } ?>" /></td>
	</tr>
	<tr>
	<td><p class="form">Confirm Password:</p></td>
	<td><input type="password" name="pass2" size="25" value="<?php if (isset($trimmed['pass2'])) { print htmlspecialchars($trimmed['pass2']); } ?>" /></td>
	</tr>
	</table>
	
	<p><input type="submit" name="submit" value=" Register " /></p>

</form>

<?//php include('include/footer.html'); // Need the footer. ?>