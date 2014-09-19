<?php // delete_user.php
// This page is for deleting a user record.
// This page is accessed through user_admin.php.

$page_title = 'Delete a User';
include ('include/generic_header.html');
include ('include/config.inc.php');

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['user_id'])) && (is_numeric($_GET['user_id'])) ) { // From user_admin.php
	$id = $_GET['user_id'];
} elseif ( (isset($_POST['user_id'])) && (is_numeric($_POST['user_id'])) ) { // Form submission.
	$id = $_POST['user_id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('include/footer.html'); 
	exit();
}

require (MYSQL);

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM users WHERE user_id=$id LIMIT 1";		
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p>The user has been deleted.</p>';	

		} else { // If the query did not run OK.
			echo '<p class="error">The user could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	
	} else { // No confirmation of deletion.
		echo '<p>The user has NOT been deleted.</p>';	
	}

} else { // Show the form.

	// Retrieve the user's information:
	$q = "SELECT CONCAT(last_name, ', ', first_name) FROM users WHERE user_id=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		
		// Display the record being deleted:
		echo "<p>Name: $row[0]</p>
		<p>Are you sure you want to delete this user?</p>";
		
		// Create the form:
		echo '<form action="delete_user.php" method="post">
	<table>
	<tr><td><p><input type="radio" name="sure" value="Yes" /> Yes</p></td></tr>
	<tr><td><p><input type="radio" name="sure" value="No" checked="checked" /> No</p></td></tr>
	<tr><td><input type="submit" name="submit" value="Submit" /></td><tr>
	</table>
	<input type="hidden" name="user_id" value="' . $id . '" />
	</form>';
	
	} else { // Not a valid user ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.

mysqli_close($dbc);
		
include ('include/footer.html');
?>