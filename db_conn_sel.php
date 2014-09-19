<?php // db_conn_sel.php
// This file contains the database access information. 
require ('include/config.inc.php');
//$dbc = @mysqli_connect ('db437696394.db.1and1.com', 'dbo437696394', 'Judges@1256', 'db437696394') OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// If no connection could be made, trigger an error:
if (!$dbc) {
	trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
} else { // Otherwise, set the encoding:
	mysqli_set_charset($dbc, 'utf8');
}