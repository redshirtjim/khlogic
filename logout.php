<?php // Script 9.8 - logout.php
/* This is the logout page. It destroys the session information. */

// Need the session:
session_start();

// Reset the session array:
$_SESSION = array();

// Destroy the session data on the server:
session_destroy();
setcookie ('PHPSESSID', '', time()-3500,'/', '', 0, 0); //Destroy the cookie.

// Define a page title and include the header:
//define('TITLE', 'Logout');
//include('include/login_header.html');
// go back to index
header('Location: index.php');




include('include/footer.html'); ?>