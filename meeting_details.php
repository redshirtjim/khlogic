<?php // - meeting_details.php
//Public Meeting page for app. It uses templates to create the layout.
session_start();
//Include the header:
//require ('include/config.inc.php'); // Require the config
include('include/header.html');
require ('include/functions.inc.php');
require_once ('include/functions_date.php');

print '<div id="sidebar" class="monday">';
$select_detail = '<select name="monday" id="monday" onchange="this.form.submit()">';
$select_title = 'Week of Monday ... ';
week_of($select_detail, $select_title); //Function in include/config.inc.php
print '</div>';

include ('include/meeting_details_schedule.php');

//Include the footer:
include('include/footer.html');
?>