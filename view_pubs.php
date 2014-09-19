<?php // - publicmeeting.php
//Public Meeting page for app. It uses templates to create the layout.
session_start();
// Include the header:
include('include/header.html');
require ('include/config.inc.php'); // Require the config
// - view_pubs.php 
/* This script retrieves blog entries from the database. */

// Connect and select:
require (MYSQL);
	
// Define the query:
$query = 'SELECT * FROM users ORDER BY last_name';
	
if ($r = mysqli_query($dbc, $query)) { // Run the query.

	// Retrieve and print every record:
	while ($row = mysqli_fetch_array($r)) {
		print "<p>{$row['first_name']} {$row['last_name']}
		<a href=\"edit_entry.php?id={$row['id']}\">Edit</a>
		<a href=\"delete_entry.php?id={$row['id']}\">Delete</a>
		</p>\n";
	}

} else { // Query didn't run.
	print '<p style="color: red;">Could not retrieve the data because:<br />' . mysql_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
} // End of query IF.

// Close the connection.
Include('db_close.php');

// Include the footer:
include('include/footer.html');

?>
