<?php // delete_pub.php This page is for deleting a publisher record. This page is accessed through admin.php.
$page = "people.php";
$title = 'Delete a Publisher';
require ('include/login_functions.inc.php');
require ('include/config.inc.php');
require ('model/data_functions.php');
if ( (isset($_GET['user_id'])) && (is_numeric($_GET['user_id'])) ) {								// Check for a valid user ID, through GET or POST
	$user_id = $_GET['user_id'];
} elseif ( (isset($_POST['user_id'])) && (is_numeric($_POST['user_id'])) ) {						// Form submission
	$user_id = $_POST['user_id'];
} else {																							// No valid ID, kill the script
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('include/footer.html'); 
	exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {															// Check if the form has been submitted
	if ($_POST['sure'] == 'Yes') {																	// Delete the record
		$r =& delete_person($user_id);																// Query in data_functions.php
		if (mysqli_affected_rows($dbc) == 1) {														// If it ran OK
			redirect_user($page);																	// Go back to admin page
		} else {																					// If the query did not run OK
			echo '<p class="error">The user could not be deleted due to a system error.</p>';		// Public message
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>';						// Debugging message
		}
	} else {																						// No confirmation of deletion
		redirect_user($page);																		// Go back to admin page
	}
} else {																							// Show the form
	$name =& get_name($user_id);
	if ($name) {
		$form_action = 'delete_person.php';
		$form_method = 'post';
		include ('include/sm_form_header.html');
		include ('view/form_delete_person.html');
	} else {																						// Not a valid user ID
		echo '<p class="error">This page has been accessed in error.</p>';
	}
}																									// End of the main submission conditional
?>