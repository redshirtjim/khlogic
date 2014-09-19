<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Date Menus</title>
</head>
<body>
<?php // weekof.php 
/* This script defines and calls a function. */

function week_of() {


	// Make the week of pull-down menu:
	print 'week of: ';
	print '<select name="monday">';
	//print '<option value=\"-28dayslastMonday\">'; print date('l, F j Y', strtotime('-28 days last Monday')); print '</option>';
	//print '<option value=\"-21dayslastMonday\">'; print date('l, F j Y', strtotime('-21 days last Monday')); print '</option>';
	//print '<option value=\"-14dayslastMonday\">'; print date('l, F j Y', strtotime('-14 days last Monday')); print '</option>';
	//print '<option value=\"-7dayslastMonday\">'; print date('l, F j Y', strtotime('-7 days last Monday')); print '</option>';
	print '<option value=\"lastMonday\">'; print date('l, F j Y', strtotime('last Monday')); print '</option>';
	print '<option value=\"firstMonday\">'; print date('l, F j Y', strtotime('first Monday')); print '</option>';
	print '<option value=\"secondMonday\">'; print date('l, F j Y', strtotime('second Monday')); print '</option>';
	print '<option value=\"thirdMonday\">'; print date('l, F j Y', strtotime('third Monday')); print '</option>';
	print '<option value=\"fourthMonday\">'; print date('l, F j Y', strtotime('fourth Monday')); print '</option>';
	print '<option value=\"+7daysfourthMonday\">'; print date('l, F j Y', strtotime('+7 days fourth Monday')); print '</option>';
	print '<option value=\"+14daysfourthMonday\">'; print date('l, F j Y', strtotime('+14 days fourth Monday')); print '</option>';
	print '<option value=\"+21daysfourthMonday\">'; print date('l, F j Y', strtotime('+21 days fourth Monday')); print '</option>';
	print '<option value=\"+28daysfourthMonday\">'; print date('l, F j Y', strtotime('+28 days fourth Monday')); print '</option>';
	print '<option value=\"+28daysfourthMonday\">'; print date('l, F j Y', strtotime('+35 days fourth Monday')); print '</option>';
	print '<option value=\"pastdates\">...past dates...</option>';
	print '</select>';
	
} // End of week_of() function.

// Make the form:
//print '<form action="" method="post">';
//week_of();
//print '</form>';

?>

</body>
</html>