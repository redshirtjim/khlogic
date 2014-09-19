<?php // menu.php
require ('include/config.inc.php');
require (MYSQL);

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

$query = "SELECT admin, public, cbs, tms, service_meet, attendants, sound_stage, cleaning, grounds FROM users WHERE user_id = $user_id AND email = '$email'";

$r = mysqli_query ($dbc, $query) OR die("MySQL errOR: " . mysqli_error($dbc) . "<hr>\nQuery: $query");

$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);

$page = $_SERVER['REQUEST_URI'];

	// GET the date for Monday for the PDF view:	
	if ($_SERVER['REQUEST_METHOD'] == 'GET' AND (strpos($host, 'khlogic.org/schedule_pdf.php') !== false) OR (strpos($host, 'khlogic.org/index.php') !== false)) {
		$monday = $_GET['monday'];
	}

	// Determine the date for Monday for initial view:
	if ($host == 'khlogic.org/index.php') { 
		 $weekday = date('N');
		 if ($weekday == 1) {
			 $monday = date('Y-m-d', strtotime('Today'));
		 } else {
			 $monday = date('Y-m-d', strtotime('last Monday'));
		 }
	}
	
	//POST the date for Monday when a date is selected in the drop down:
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND (strpos($host, 'khlogic.org/index.php') !== false)) {
		$monday = $_POST['monday'];
	}

if (strpos($page, 'index.php') !== false) {
	$home_link = '<li class="active"><a class="active" href="index.php" title="Home"><span class="glyphicon glyphicon-home"></span></a></li>';
} else { 
	$home_link = '<li><a href="Index.php" title="Home"><span class="glyphicon glyphicon-home"></span></a></li>';
}
if (strpos($page, 'publicmeeting.php') !== false) {
	$public_meeting_link = '<li class="active"><a class="active" >EDIT: Public Meeting</a></li>';
}
if (strpos($page, 'cbs.php') !== false) {
	$cbs_link = '<li class="active"><a class="active" >EDIT: Congregation Bible Study</a></li>';
}
if (strpos($page, 'tms.php') !== false) {
	$tms_link = '<li class="active"><a class="active" >EDIT: Theocratic Ministry School</a></li>';
}
if (strpos($page, 'servicemeeting.php') !== false) {
	$service_meeting_link = '<li class="active"><a class="active" >EDIT: Service Meeting</a></li>';
}
if (strpos($page, 'attendent') !== false) {
	$attendants_link = '<li class="active"><a class="active" >EDIT: Attendants</a></li>';
}
if (strpos($page, 'sound.php') !== false) {
	$sound_link = '<li class="active"><a class="active" >EDIT: Sound & Stage</a></li>';
}
if (strpos($page, 'khcleaning.php') !== false) {
	$khcleaning_link = '<li class="active"><a class="active" >EDIT: Kingdom Hall Cleaning</a></li>';
}
if (strpos($page, 'grounds.php') !== false) {
	$grounds_link = '<li class="active"><a class="active" >EDIT: Grounds Keeping</a></li>';
}
if ($page == '/people.php' OR (strpos($page, 'person.php') !== false)) {
	$people_link = '<li class="active"><a class="active" href="people.php" title="People"><span class="glyphicon glyphicon-user"></span></a></li>';
} else { 
	$people_link = '<li><a href="people.php" title="People"><span class="glyphicon glyphicon-user"></span></a></li>';
}
if ($page == '/user_admin.php' OR (strpos($page, 'user.php') !== false)) {
	$admin_link = '<li class="active"><a class="active" href="user_admin.php" title="Administration"><span class="glyphicon glyphicon-wrench"></span></a></li>';
} else { 
	$admin_link = '<li><a href="user_admin.php" title="Administration"><span class="glyphicon glyphicon-wrench"></span></a></li>';
}
if ($page == '/my_assign.php') {
	$my_assign_link = '<li class="active"><a class="active" href="my_assign.php" title="View Your Assignments"><span class="glyphicon glyphicon-asterisk">My Assignments</span></a></li>';
} else { 
	$my_assign_link = '<li><a href="my_assign.php" title="View Your Assignments"><span class="glyphicon glyphicon-asterisk">My Assignments</span></a></li>';
}
if ($page == '/meeting_details.php') {
	$material_link = '<li class="active"><a class="active" href="edit_details.php?monday=' . $monday . '" title="Material"><span class="glyphicon glyphicon-book"></span></a></li>';
} else { 
	$material_link = '<li><a href="edit_details.php?monday=' . $monday . '" title="Material"><span class="glyphicon glyphicon-book"></span></a></li>';
}
if (strpos($page, '/your_user_settings.php') !== false OR strpos($page, '/edit_your_user_settings.php') !== false) {
	$user_settings_link = '<li class="active"><a class="active" href="your_user_settings.php?user_id=' . $user_id . '" title="Your Settings"><span class="glyphicon glyphicon-cog"></span></a></li>';
} else { 
	$user_settings_link = '<li><a href="your_user_settings.php?user_id=' . $user_id . '" title="Your Settings"><span class="glyphicon glyphicon-cog"></span></a></li>';
}
if (strpos($page, 'index.php') !== false) {
	$pdf_link = '<li> <a href="schedule_pdf.php?monday=' . $monday . '" target="blank" title="PDF for Printing"><span class="glyphicon glyphicon-file"></span></a></li>';
}

$logout_link = '<li><a class="active" href="logout.php" title="Logout"><span class="glyphicon glyphicon-log-out"></span></a></li>';

print '
<!--<div id="nav" class="">-->
<ul class="nav nav-pills pull-right">';
echo $home_link;
echo $my_assign_link;
echo $pdf_link;

	if (($row['admin'] != FALSE) OR ($row['public'] != FALSE)) {
		echo $public_meeting_link;
		}
	if ($row['admin'] != FALSE OR $row['cbs'] != FALSE) {
		print $cbs_link;
		}
	if ($row['admin'] != FALSE OR $row['tms'] != FALSE) {
		print $tms_link;
		}
	if ($row['admin'] != FALSE OR $row['service_meet'] != FALSE) {
		print $service_meeting_link;
		}
	if ($row['admin'] != FALSE OR $row['attendants'] != FALSE) {
		print $attendants_link;
		}
	if ($row['admin'] != FALSE OR $row['sound_stage'] != FALSE) {
		print $sound_link;
		}
	if ($row['admin'] != FALSE OR $row['cleaning'] != FALSE) {
		print $khcleaning_link;
		}
	if ($row['admin'] != FALSE OR $row['grounds'] != FALSE) {
		print $grounds_link;
		}
		if ($row['admin'] != FALSE) {
		print $people_link;
		}
	if ($row['admin'] != FALSE) {
		echo $admin_link;
		}
	if ($row['admin'] != FALSE) {
		echo $material_link;
	}
echo $user_settings_link;
echo $logout_link;
print '</ul>';

// Close the connection.
mysqli_free_result ($r); // Free up the resources.
mysqli_close($dbc);
		
?>