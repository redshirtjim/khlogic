<?php // Script 8.14 - welcome.php
/* This is the welcome page. The user is redirected here
after they successfully log in. */

// Need to access the session:
session_start();

// Set the page title and include the header file:
define('TITLE', 'Welcome to Kingdom Hall Meeting Schedules');
include('include/header.html');

// Print a greeting:
print '<h2>Welcome to KHMeeting Schedule</h2>';
print '<p>Hello, ' . $_SESSION['email'] . '</p>';

// Print how long they've been logged in:
date_default_timezone_set('America/Chicago');
print '<p>You have been logged in since: ' . date('g:i A l, F j Y', $_SESSION['loggedin']) . '</p>';

// Make a logout link:
print '<p><a href="logout.php">Click here to logout.</a></p>';

include('include/footer.html'); // Need the footer. 
?>