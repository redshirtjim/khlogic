<?php // - watchtower.php
//Watchtower Study page for app. It uses templates to create the layout.
session_start();
//Include the header:
//require ('include/config.inc.php'); // Require the config
include('include\header.html');
print 'Watchtower Study';
require('weekof.php');
week_of();
?>

<p>Use this application to schedule all meeting activities</p>

<form action="index.php" method="post">
	<table>
		<tr>
		<td>Chairman:</td>
		<td><input type="password" name="chairman" size="20" /></td>
		</tr>
		<tr>
		<td>Watchtower Reader:</td>
		<td><input type="password" name="wtreader" size="20" /></td>
		</tr>
		</table>
		<br>
		<p><input type="submit" name="submit" value=" Submit " /></p>
		</form>

<?php
//Include the footer:
include('include\footer.html');
?>