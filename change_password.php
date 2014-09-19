<?php // - change_password.php This page allows a logged-in user to change their password.
session_start();
$title = 'Change Password';
$form_action = 'change_password.php';
$form_method = 'post';
$pass_msg = '';
require ('include/config.inc.php');
require ('model/data_functions.php');
if (!isset($_SESSION['user_id'])) {																		// If no user_id session variable exists, redirect the user
	$url = BASE_URL . 'index.php'; 																		// Define the URL
	ob_end_clean(); 																					// Delete the buffer
	header("Location: $url");
	exit(); 																							// Quit the script
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$p = FALSE;
	if (preg_match ('/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $_POST['pass1']) ) {				// Check for a new password and match against the confirmed password:
		if ($_POST['pass1'] == $_POST['pass2']) {
			require (MYSQL);
			$p = mysqli_real_escape_string ($dbc, $_POST['pass1']);										//mysqli real escape string requires a db connection
			require (CLSMYSQL);
		} else {
			$pass_msg .= '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		$pass_msg .= '<p class="error">Please enter a valid password!</p>';
	}
	if ($p) {																							// If everything's OK
		
		$user_id = $_SESSION['user_id'];
		$success =& change_password($p, $user_id);
		if ($success == 1) {
			$pass_msg .= '<h3>Your password has been changed.</h3>';
			$pass_msg .= '<a href="logout.php" class="change_password_btn" ><button type="button" class="btn btn-primary">Re-Login</button></a>';
		} else {																						// If it did not run OK
			$pass_msg .= '<p class="error">Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.</p>'; 
		}
	} else {																							// Failed the validation test
		$pass_msg .=  '<p class="error">Please try again.</p>';		
	}
}																										// End of the main Submit conditional
require ('include/sm_form_header.html');
include ('view/form_change_password.html');
?>