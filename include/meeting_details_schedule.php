<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
	
	$monday = $_POST['monday'];	
//	define('MONDAY', $monday);
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('F j, Y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('F j, Y', strtotime('+6 days', strtotime($monday)));

}
require (MYSQL);

$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (strpos($host, 'khlogic.org/meeting_details.php') !== false) {
	
	echo '<br /><b>' . $date . ' - ' . $sunday;
	echo '<br /><br />Talk Material</b>&nbsp';
	echo '<a href="edit_details.php?monday=' . $_POST['monday'] . '" class="edit-button">EDIT</a><br /><br />';

	$cts_query = "SELECT *
	FROM cts_detail
	WHERE week_of = '$monday'";
	
	$cts_r = mysqli_query ($dbc, $cts_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\ncts_query: $cts_query");
	
	while ($cts_row = mysqli_fetch_array($cts_r)) {
		
		$song_1 = $cts_row['song_1'];
		$cbs = $cts_row['cbs'];
		$bible_read = $cts_row['bible_read'];
		$no_1 = $cts_row['no_1'];
		$no_2 = $cts_row['no_2'] . ' (' . $cts_row['no_2_source'] . ')';
		$no_3 = $cts_row['no_3'] . ' (' . $cts_row['no_3_source'] . ')';
		$song_2 = $cts_row['song_2'];
		$sm_1 = $cts_row['sm_1'];
		$sm_2 = $cts_row['sm_2'];
		$sm_3 = $cts_row['sm_3'];
		$song_3 = $cts_row['song_3'];
			
		print '
		<table>
			<tr>
			<td><b>Congregation Bible Study</b></td>
			</tr>
			<tr>
			<td>Song:&nbsp</td><td>' . $song_1 . '</td>
			</tr>
			<tr>
			<td>Bible Study:&nbsp</td><td>' . $cbs . '</td>
			</tr>
			<tr>
			<td><b>Theocratic Ministry School</b></td>
			</tr>
			<td>Bible Reading:&nbsp</td><td>' . $bible_read . '</td>
			</tr>
			<tr>
			<td>No. 1:&nbsp</td><td>' . $no_1 . '</td>
			</tr>
			<tr>
			<td>No. 2:&nbsp</td><td>' . $no_2 . '</td>
			</tr>
			<tr>
			<td>No. 3:&nbsp</td><td>' . $no_3 . '</td>
			</tr>
			<tr>
			<td><b>Service Meeting</b></td>
			</tr>
			<tr>
			<td>Song:&nbsp</td><td>' . $song_2 . '</td>
			</tr>
			<tr>
			<td>SM Part 1:&nbsp</td><td>' . $sm_1 . '</td>
			</tr>
			<tr>
			<td>SM Part 2:&nbsp</td><td>' . $sm_2 . '</td>
			</tr>
			<tr>
			<td>SM Part 3:&nbsp</td><td>' . $sm_3 . '</td>
			</tr>
			<tr>
			<td>Song:&nbsp</td><td>' . $song_3 . '</td>
			</tr>
		</table>';
	} // END Loop.
	
	$ptws_query = "SELECT *
	FROM ptws_detail
	WHERE week_of = '$monday'";
	
	$ptws_r = mysqli_query ($dbc, $ptws_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nptws_query: $ptws_query");
	
	while ($ptws_row = mysqli_fetch_array($ptws_r)) {
		
		$ptws_song_1 = $ptws_row[2];
		$ptws_song_2 = $ptws_row[3];
		$wt_study = $ptws_row[6];
		$ptws_song_3 = $ptws_row[4];
			
		print '
		<table>
			<tr>
			<td><b>Public Meeting</b></td>
			</tr>
			<tr>
			<td>Song:&nbsp</td><td>' . $ptws_song_1 . '</td>
			</tr>
			<tr>
			<td>Song:&nbsp</td><td>' . $ptws_song_2 . '</td>
			</tr>
			<tr>
			<td>Watchtower Study Article:&nbsp</td><td>' . $wt_study . '</td>
			</tr>
			<tr>
			<td>Song:&nbsp</td><td>' . $ptws_song_3 . '</td>
			</tr>
		</table>';
	}	// END Loop.
	
	print '<br>';
} // END IF conditional for URL.