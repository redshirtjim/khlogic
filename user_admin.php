<?php // - user_admin.php Admin page used to view, (edit) application schedulers.
session_start();
require ('include/config.inc.php');
include ('include/header.html');
require (MYSQL);
$query = "SELECT user_id, servant_type_id, CONCAT(last_name, ', ', first_name) AS Name, admin, public, cbs, tms, service_meet, attendants, sound_stage, cleaning, grounds
	FROM users WHERE admin =1 OR public = 1 OR cbs = 1 OR tms = 1 OR service_meet = 1 OR attendants = 1 OR sound_stage = 1 OR cleaning = 1 OR grounds = 1
	ORDER BY last_name, first_name";
$r = mysqli_query ($dbc, $query);
$num = mysqli_num_rows($r);	
if ($num > 0) {																				// If it ran OK, display the records.
																							// Table header	
	echo '
	<div id="" class="">
	<table align="center" cellspacing="0" cellpadding="3" width="100%">
	<tr><td align="left"><b> </b></td>
	<td align="left"><b>Name</b></td>
	<td align="center"><b>Admin</b></td>
	<td align="center"><b>Public</b></td>
	<td align="center"><b>CBS</b></td>
	<td align="center"><b>TMS</b></td>
	<td align="center"><b>Service</b></td>
	<td align="center"><b>Attend</b></td>
	<td align="center"><b>Snd&Stg</b></td>
	<td align="center"><b>Cleaning</b></td>
	<td align="center"><b>Grounds</b></td></tr>';
	$bg = '#eeeeee';																		//Set alternate background for each row; Set initial background color
	while ($row = mysqli_fetch_array($r)) {													// Fetch and echo all the records
	$tick = '<img src="img/tick.ico" width="12" height="12">';
	$minus = '<img src="img/minus.ico" width="12" height="12">';
	$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');										//Switch the background color
	echo '
	<tr bgcolor="' . $bg . '">
	<td align="left"><a href=edit_user.php?user_id=' . $row['user_id'] . '><span class="glyphicon glyphicon-edit"></span></a></td>
	<td align="left">' . $row['Name'] . '</td>
	<td align="center">'; 
	$rowadmin = $row['admin'];
	if ($rowadmin == TRUE) {
			echo $tick;
			} else if ($rowadmin == FALSE) { 
				echo '';} 
	echo '</td>
	<td align="center">'; 
	$rowpublic = $row['public'];
	if ($rowpublic == TRUE) {
			echo $tick;
			} else if ($rowpublic == FALSE) { 
				echo '';} 
	echo '</td>		
	<td align="center">'; 
	$rowcbs = $row['cbs'];
	if ($rowcbs == TRUE) {
			echo $tick;
			} else if ($rowcbs == FALSE) { 
				echo '';} 
	echo '</td>		
	<td align="center">'; 
	$rowtms = $row['tms'];
	if ($rowtms == TRUE) {
			echo $tick;
			} else if ($rowtms == FALSE) { 
				echo '';} 
	echo '</td>		
	<td align="center">'; 
	$rowservice_meet = $row['service_meet'];
	if ($rowservice_meet == TRUE) {
			echo $tick;
			} else if ($rowservice_meet == FALSE) { 
				echo '';} 
	echo '</td>		
	<td align="center">'; 
	$rowattendants = $row['attendants'];
	if ($rowattendants == TRUE) {
			echo $tick;
			} else if ($rowattendants == FALSE) { 
				echo '';} 
	echo '</td>		
	<td align="center">'; 
	$rowsound_stage = $row['sound_stage'];
	if ($rowsound_stage == TRUE) {
			echo $tick;
			} else if ($rowsound_stage == FALSE) { 
				echo '';} 
	echo '</td>		
	<td align="center">'; 
	$rowcleaning = $row['cleaning'];
	if ($rowcleaning == TRUE) {
			echo $tick;
			} else if ($rowcleaning == FALSE) { 
				echo '';} 
	echo '</td>		
	<td align="center">'; 
	$rowgrounds = $row['grounds'];
	if ($rowgrounds == TRUE) {
			echo $tick;
			} else if ($rowgrounds == FALSE) { 
				echo '';} 
	echo '</td></tr>';
	}
	echo '</table>';																		// Close the table
	mysqli_free_result ($r);																// Free up the resources	
} else {																					// Query didn't run
	echo '<p style="color: red;">Could not retrieve the data because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
}																							// End of query IF
echo '</div>';
require (CLSMYSQL);																			// Close the database connection
include('include/footer.html');																//Include the footer
?>