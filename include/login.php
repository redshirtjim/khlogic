<?php # login.php
// This page processes the login form submission.
// The script uses sessions.

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Need two helper files:
	require ('include/login_functions.inc.php');
	require ('include/config.inc.php');
	require (MYSQL);
	//require ('include/login_functions.inc.php');
		
	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['password']);
	
	if ($check) { // OK!
		
		// Set the session data:
		session_start();
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['email'] = $data['email'];
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['last_name'] = $data['last_name'];
		
		//Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		// Redirect:
		$page = 'index.php';
		redirect_user($page);
			
	} else { // Unsuccessful!

		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;

	}
		
	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

// Create the page:
include ('include/login_page.inc.php');
?>