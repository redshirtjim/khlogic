<?php // register.php -Script 8.9
/* This page lets people register for the site (in theory). */

// Set the page title and include the header file:
define('TITLE', 'Register');
include('include/header.html');

// Print some introductory text:
print '<h2>Registration Form</h2>
	<p>Register - There will be 3 types of users: standard users who can view schedules; administrators who can create and schedule publishers; and super administrator who can create and schedule publishers and create administrators.</p>';
	
// Add the CSS:
print '<style type="text/css" media="screen">
	.error { color: red; }
	</style>';

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$problem = FALSE; // No problems so far.
	
	// Check for each value...
	if (empty($_POST['first_name'])) {
		$problem = TRUE;
		print '<p class="error">Please enter your first name!</p>';
	}
	
	if (empty($_POST['last_name'])) {
		$problem = TRUE;
		print '<p class="error">Please enter your last name!</p>';
	}

	if (empty($_POST['email']) || (substr_count($_POST['email'], '@' != 1))) {
		$problem = TRUE;
		print '<p class="error">Please enter your email address!</p>';
	}

	if (empty($_POST['password1'])) {
		$problem = TRUE;
		print '<p class="error">Please enter a password!</p>';
	}

	if ($_POST['password1'] != $_POST['password2']) {
		$problem = TRUE;
		print '<p class="error">Your password did not match your confirmed password!</p>';
	} 
	
	if (!$problem) { // If there weren't any problems...

		// Print a message:
		print '<p>You are now registered!<br />Okay, you are not really registered but...</p>';
		
		// Send a registration notice to the email
		$body = "Thank you for registering with KH Meeting. Your password is '{$_POST[password1]}'.";
		mail($_POST['mail'], 'KH Meeting Registration Confirmed', $body);
	
		// Clear the posted values only if the form is successfully filled:
		$_POST = array();
	
	} else { // Forgot a field.
	
		print '<p class="error">Please try again!</p>';
		
	}

} // End of handle form IF.

// Create the form: each if conditional checks for form input for "sticky form"
?>
<form action="register.php" method="post">

	<table>
	<tr>
	<td>First Name:</td>
	<td><input type="text" name="first_name" size="20" value="<?php if (isset($_POST['first_name'])) { print htmlspecialchars($_POST['first_name']); } ?>" /></td>
	</tr>
	<tr>
	<td>Last Name:</td>
	<td><input type="text" name="last_name" size="20" value="<?php if (isset($_POST['last_name'])) { print htmlspecialchars($_POST['last_name']); } ?>" /></td>
	</tr>
	<tr>
	<td>Email Address:</td>
	<td><input type="email" name="email" size="20" value="<?php if (isset($_POST['email'])) { print htmlspecialchars($_POST['email']); } ?>" /></td>
	</tr>
	<tr>
	<td>Password:</td>
	<td><input type="password" name="password1" size="20" value="<?php if (isset($_POST['password1'])) { print htmlspecialchars($_POST['password1']); } ?>" /></td>
	</tr>
	<tr>
	<td>Confirm Password:</td>
	<td><input type="password" name="password2" size="20" value="<?php if (isset($_POST['password2'])) { print htmlspecialchars($_POST['password2']); } ?>" /></td>
	</tr>
	</table>
	
	<p><input type="submit" name="submit" value="Register!" /></p>

</form>

<?php include('include/footer.html'); // Need the footer. ?>