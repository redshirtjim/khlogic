<?php # Script 9.7 - password.php
// This page lets a user change their password.

$page_title = 'Change Your Password';
include ('include/generic_header.html');
require ('include/config.inc.php'); // Require the config

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require (MYSQL); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	// Check for the current password:
	if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your current password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	}

	// Check for a new password and match 
	// against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your new password did not match the confirmed password.';
		} else {
			$np = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your new password.';
	}
	
	if (empty($errors)) { // If everything's OK.

		// Check that they've entered the right email address/password combination:
		$q = "SELECT user_id FROM users WHERE (email='$e' AND passw=SHA1('$p') )";
		$r = @mysqli_query($dbc, $q);
		$num = @mysqli_num_rows($r);
		if ($num == 1) { // Match was made.
	
			// Get the user_id:
			$row = mysqli_fetch_array($r, MYSQLI_NUM);

			// Make the UPDATE query:
			$q = "UPDATE users SET passw=SHA1('$np') WHERE user_id=$row[0]";		
			$r = @mysqli_query($dbc, $q);
			
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message.
				echo '<h1>Thank you!</h1>
				<p>Your password has been updated. In Chapter 12 you will actually be able to log in!</p><p><br /></p>';	

			} else { // If it did not run OK.

				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>'; 
	
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
	
			}

			mysqli_close($dbc); // Close the database connection.

			// Include the footer and quit the script (to not show the form).
			include ('include/footer.html'); 
			exit();
				
		} else { // Invalid email address/password combination.
			echo '<h1>Error!</h1>
			<p class="error">The email address and password do not match those on file.</p>';
		}
		
	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
	
	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.
		
} // End of the main Submit conditional.
?>
<p>Change Your Password</p>
<form action="password.php" method="post">
	<table>
	<tr>
	<td>Email Address: </td><td><input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /></td>
	</tr><tr>
	<td>Current Password: </td><td><input type="password" name="pass" size="20" maxlength="60" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>"  /></td>
	</tr><tr>
	<td>New Password: </td><td><input type="password" name="pass1" size="20" maxlength="60" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></td>
	</tr><tr>
	<td>Confirm New Password: &nbsp </td><td><input type="password" name="pass2" size="20" maxlength="60" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"  /></td></tr>
	</table>
	<p><input type="submit" name="submit" value="Change Password" /></p>
</form>
<?php include ('include/footer.html'); ?>