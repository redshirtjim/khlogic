<?php // - edit_publicmeeting.php
/*Allows a scheduler to assign parts/tasks.
1. Check if user has permission to view the page
2. Display a select/option form for each assignment based on data from the assignments table
3. Each form is submitted when the selection is changed
4. When a form is submitted with a set user id in the POST, then a record in the assignments table is either inserted or updated.*/

session_start();

// *** First, check if user has permission to view the page ***

require ('db_conn_sel.php'); // Database connection.

// Assign the sessions varibles:
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

// Determine the TRUE (1) or FALSE (0) value for the admin & public fields of users table:
$query = "SELECT admin, public FROM users WHERE user_id = $user_id AND email = '$email'";
$r = mysqli_query ($dbc, $query) OR die("MySQL security check error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
// If neither public nor admin is TRUE (1), the user is redirected to index. If either public or admin is TRUE (1), then the script continues.
if ($row['public'] != TRUE AND $row['admin'] != TRUE) {
	require ('include/functions.inc.php');
	redirect_user('index.php'); 
	require('db_close.php'); // Close the database connection.
// *** END permission check ***

} else {
	
	// *** Handle the Forms. ***
	require ('include/config.inc.php'); // Global config.
	require ('include/functions.inc.php'); // Global config.
	$monday = $_GET['monday']; // Date value from URL. Always represents the date of a Monday of the week.
	$date = date('F j, Y', strtotime($monday));
	$midweek = date('F j, Y', strtotime('+2 days', strtotime($monday)));
	$sunday = date('F j, Y', strtotime('+6 days', strtotime($monday)));
	$nextw = date('Y-m-d', strtotime('+7 days', strtotime($monday)));
	$prevw = date('Y-m-d', strtotime('-7 days', strtotime($monday)));
	$currw = date('Y-m-d', strtotime('last Monday'));
	$defcong = DEF_CONG;
	
	
	// *** Update or insert local public speaker assignment ***
	
	// Check if form is posted and if the user id value is set in the post.	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['localspeaker_sel']) AND isset ($_POST['theme'])) {
		$user_id = $_POST['localspeaker_sel']; // Assign user id to variable.
		$theme_id = $_POST['theme'];
		$congr_id = 1;
                
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, 1, 1);	// meeting_type_id = 2, assign_type_id = 1, page_id = 1
		handle_cong_theme_post($monday, $congr_id, $theme_id, 2, 1, 1);	// meeting_type_id = 2, assign_type_id = 1, page_id = 1
				
 		//Check for a talk record for visiting speaker assigned ( not outgoing and not local ) and if found, delete it.
		$query = "SELECT * FROM talks WHERE week_of = '$monday' AND outgoing = 0";
		$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
		$row = mysqli_fetch_array($r);
		$cong = mysqli_real_escape_string($dbc, strip_tags($defcong));
        $talk_id = $row['talk_id'];
		
 		if (mysqli_num_rows($r) > 0) {
	 		$query = "DELETE FROM talks WHERE talk_id = '$talk_id' LIMIT 1";
	 		$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
 		} 
	}
 	
	// ***  END Update or insert local public speaker assignment ***

	// *** Update or insert OUTGOING public speaker assignment ***
	
	// Check if form is posted and if the user id value is set in the post.	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['outspeaker']) AND isset($_POST['out_theme']) AND isset ($_POST['out_cong'])) {
		$user_id = $_POST['outspeaker']; // Assign user id to variable.
		$theme_id = $_POST['out_theme'];
		$congr_id = $_POST['out_cong'];
		
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, 6, 1);	// meeting_type_id = 2, assign_type_id = 6, page_id = 1
		handle_cong_theme_post($monday, $congr_id, $theme_id, 2, 6, 1);	// meeting_type_id = 2, assign_type_id = 6, page_id = 1		
		
		/*
		// If assigning an outgoing speaker, then the talks record must be updated if one exists
		$query_name = "SELECT CONCAT(first_name,' ',last_name) AS 'Name' FROM users WHERE user_id = '$user_id'";
		$r_query_name = mysqli_query ($dbc, $query_name) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query_name");
		$row_query_name = mysqli_fetch_array($r_query_name);
 		$name = $row_query_name['Name'];

		$query = "SELECT * FROM talks WHERE week_of = '$monday' AND outgoing = 1 AND local_sp = 1";
		$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
		$row = mysqli_fetch_array($r);
		
 		if (mysqli_num_rows($r) > 0) {
	 		$talk_id = $row['talk_id'];
	 		$query = "UPDATE talks SET name = '$name', phone = '', no_hosp = '', cong = '$cong', theme_id = '$theme', local_sp = 1, outgoing = 1 WHERE talk_id = '$talk_id'";
            $r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
 		} else {
	 		$query = "INSERT INTO talks (week_of, name, cong, theme_id, local_sp, outgoing) VALUES ('$monday', '$name', '$cong', '$theme', 1, 1)";
            $r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
		}*/
	}
	
	// SECOND OUTGOING SPEAKER. Check if form is posted and if the user id value is set in the post.	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['outspeaker2']) AND isset($_POST['out_theme2']) AND isset ($_POST['out_cong2'])) {
		$user_id = $_POST['outspeaker2']; // Assign user id to variable.
		$theme_id = $_POST['out_theme2'];
		$congr_id = $_POST['out_cong2'];
		
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, 39, 1);	// meeting_type_id = 2, assign_type_id = 39, page_id = 1
		handle_cong_theme_post($monday, $congr_id, $theme_id, 2, 39, 1);	// meeting_type_id = 2, assign_type_id = 39, page_id = 1	
	}	

	// THIRD OUTGOING SPEAKER. Check if form is posted and if the user id value is set in the post.	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['outspeaker3']) AND isset($_POST['out_theme3']) AND isset ($_POST['out_cong3'])) {
		$user_id = $_POST['outspeaker3']; // Assign user id to variable.
		$theme_id = $_POST['out_theme3'];
		$congr_id = $_POST['out_cong3'];
		
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, 40, 1);	// meeting_type_id = 2, assign_type_id = 40, page_id = 1
		handle_cong_theme_post($monday, $congr_id, $theme_id, 2, 40, 1);	// meeting_type_id = 2, assign_type_id = 40, page_id = 1	
	}	

	 	
	// ***  END Update or insert local OUTGOING public speaker assignment ***
	
		
	// *** Update or insert chairman assignment ***
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['chairman'])) {
		$user_id = $_POST['chairman'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, 2, 1);	// meeting_type_id = 2, assign_type_id = 2, page_id = 1
	}
 	
	// ***  END Update or insert public chairman assignment ***	
	
	// *** Update or insert wtreader assignment ***
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['wtreader'])) {
		$user_id = $_POST['wtreader'];
		$conflict_msg =& handle_assignment_post($monday, $user_id, 2, 4, 1);	// meeting_type_id = 2, assign_type_id = 4, page_id = 1
	}
	// *** END Update or insert public wtreader assignment ***

	// *** VISITING SPEAKER
		
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND !empty($_POST['visit_speaker']) AND isset ($_POST['visit_cong']) AND isset ($_POST['visit_theme'])) {
 		$name = mysqli_real_escape_string($dbc, strip_tags($_POST['visit_speaker']));
		$congr_id = $_POST['visit_cong'];
		$theme_id = $_POST['visit_theme'];
		$phone = mysqli_real_escape_string($dbc, strip_tags($_POST['visit_speaker_phone']));
		$no_hosp = mysqli_real_escape_string($dbc, strip_tags($_POST['visit_no_hosp']));
        
		// Check if a visiting speaker record already exists - if so, update the record        
        $query = "SELECT * FROM talks WHERE week_of = '$monday' AND outgoing = 0";
		$r = mysqli_query($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
		$row = mysqli_fetch_array($r);
				
 		if (mysqli_num_rows($r) > 0) {
	 		$talk_id = $row['talk_id'];
	 		$query = "UPDATE talks SET name = '$name', phone = '$phone', no_hosp = '$no_hosp', congr_id = '$congr_id', theme_id = '$theme_id', local_sp = 0, outgoing = 0 WHERE talk_id = '$talk_id'";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");

			// If assigning a visiting speaker, then the local speaker record must be deleted if one exists
			$query_assign = "SELECT assign_id FROM assignments WHERE week_of = '$monday' AND assign_type_id = 1 AND page_id = 1";
			$r_assign = mysqli_query($dbc, $query_assign) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query_assign");
			$row_assign = mysqli_fetch_array($r_assign);
			$assign_id = $row_assign['assign_id'];
			if (mysqli_num_rows($r_assign) > 0) {
				$query_delete = "DELETE FROM assignments WHERE assign_id = '$assign_id' LIMIT 1";
				//echo $query_delete; 
				$r_delete = mysqli_query($dbc, $query_delete) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query_delete");
			}
			
 		} else {
	 		//  - if not, insert the record and check if a local speaker had been assigned already - if so, delete that record from assignments table
	 		$query = "INSERT INTO talks (week_of, name, phone, no_hosp, congr_id, theme_id) VALUES ('$monday', '$name', '$phone', '$no_hosp', '$congr_id', '$theme_id')";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			
			// If assigning a visiting speaker, then the local speaker record must be deleted if one exists
			$query_assign = "SELECT assign_id FROM assignments WHERE week_of = '$monday' AND assign_type_id = 1 AND page_id = 1";
			$r_assign = mysqli_query($dbc, $query_assign) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query_assign");
			$row_assign = mysqli_fetch_array($r_assign);
			$assign_id = $row_assign['assign_id'];
			if (mysqli_num_rows($r_assign) > 0) {
				$query_delete = "DELETE FROM assignments WHERE assign_id = '$assign_id' LIMIT 1";
				//echo $query_delete; 
				$r_delete = mysqli_query($dbc, $query_delete) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query_delete");
			}
		}
	}
	
	// *** END Handle the Forms. ***
	
	// *** Create the Forms. Each form submits when a selection option is chosen. ***
 	
	//Include the header:
	include('include/header.html');
	print "<p><b>The week of $date<br>Meeting date $sunday</b></p>";
	require ('db_conn_sel.php');
	
	// Database query variables for meeting details (titles of themes, sources material)

	$ptws_query = "SELECT *
	FROM ptws_detail
	WHERE week_of = '$monday'";

	$ptws_r = mysqli_query ($dbc, $ptws_query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nptws_query: $ptws_query");
	
	while ($ptws_row = mysqli_fetch_array($ptws_r)) {
		
		$ptws_song_1 = $ptws_row[2];
		$theme = $ptws_row[5];
		$ptws_song_2 = $ptws_row[3];
		$wt_study = $ptws_row[6];
		$ptws_song_3 = $ptws_row[4];
	}
	
	// END Database query variables for meeting details (titles of themes, sources material)
		
	// *** Database query variables for forms select options ***
	
	// Database query variables for when there is no assignment record yet existing. Show those who are approved for various assignments.

	$r1 =& show_approved(public_speaker); // Local speaker
	$r6 =& show_approved(public_speaker); // Outgoing speaker 1
	$r10 =& show_approved(public_speaker); // Outgoing speaker 2
	$r13 =& show_approved(public_speaker); // Outgoing speaker 3
	$r2 =& show_approved(chairman);
	//$r3 =& show_approved(theme);
	$r4 =& show_approved(reader);
	
	//Select all the themes of the drop down(s)
	$query3 = "SELECT * FROM themes ORDER BY theme_id";
	$r3 = mysqli_query ($dbc, $query3) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query3");

	$query5 = "SELECT * FROM themes ORDER BY theme_id";
	$r5 = mysqli_query ($dbc, $query5) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query5");

	$query7 = "SELECT * FROM themes ORDER BY theme_id";
	$r7 = mysqli_query ($dbc, $query7) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query7");

	$query12 = "SELECT * FROM themes ORDER BY theme_id";
	$r12 = mysqli_query ($dbc, $query12) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query12");

	$query14 = "SELECT * FROM themes ORDER BY theme_id";
	$r14 = mysqli_query ($dbc, $query14) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query15");
	
	//Select all the Congregation of the drop down(s)
	$query8 = "SELECT * FROM congregations ORDER BY congregation";
	$r8 = mysqli_query ($dbc, $query8) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query8");

	$query9 = "SELECT * FROM congregations ORDER BY congregation";
	$r9 = mysqli_query ($dbc, $query9) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query9");	

	$query11 = "SELECT * FROM congregations ORDER BY congregation";
	$r11 = mysqli_query ($dbc, $query11) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query11");	

	$query16 = "SELECT * FROM congregations ORDER BY congregation";
	$r16 = mysqli_query ($dbc, $query16) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query16");	
		
	// Database query variables for when assignment record exists. The query returns data from users table and assignments table.
	
	// speaker query
	$row_speaker =& assign_record_exists($monday, 1, 1); //page_id = 1 AND assign_type_id = 1
	$num_row_speaker = mysqli_num_rows($row_speaker);
	if ($row_speaker['user_id'] > 0) {
		$local = 1;
	} else {
		$local = 0;
	}

	// outgoing speaker query
	$row_out_speaker =& assign_record_exists($monday, 1, 6); //page_id = 1 AND assign_type_id = 6
	$num_row_out_speaker = mysqli_num_rows($row_out_speaker);
	if ($row_out_speaker['user_id'] > 0) {
		$out_speaker = 1;
	} else {
		$out_speaker = 0;
	}

		// outgoing speaker 2 query
	$row_out_speaker_2 =& assign_record_exists($monday, 1, 39); //page_id = 1 AND assign_type_id = 39
	$num_row_out_speaker_2 = mysqli_num_rows($row_out_speaker_2);
	if ($row_out_speaker_2['user_id'] > 0) {
		$out_speaker_2 = 1;
	} else {
		$out_speaker_2 = 0;
	}

	// outgoing speaker 3 query
	$row_out_speaker_3 =& assign_record_exists($monday, 1, 40); //page_id = 1 AND assign_type_id = 40
	$num_row_out_speaker_3 = mysqli_num_rows($row_out_speaker_3);
	if ($row_out_speaker_3['user_id'] > 0) {
		$out_speaker_3 = 1;
	} else {
		$out_speaker_3 = 0;
	}
		
	$query_visit_talks = "SELECT talk_id, week_of, name, phone, no_hosp, congr_id, c.congregation AS Cong, theme_id, CONCAT (t.theme_id,' ',t.theme) AS Theme, local_sp 
		FROM talks
		INNER JOIN themes AS t
		USING ( theme_id )
		INNER JOIN congregations AS c
		USING ( congr_id )
		WHERE week_of = '$monday' AND local_sp = 0 AND outgoing = 0";
	$r_visit_talks = mysqli_query ($dbc, $query_visit_talks) OR die("MySQL error_visit_talks: " . mysqli_error($dbc) . "<hr>\nQuery: $query_visit_talks");
	$row_visit_talks = mysqli_fetch_array($r_visit_talks);
	$num_row_visit_talks = mysqli_num_rows($row_visit_talks);
        //echo $query_visit_talks . '<br>';
	
	$query_local_talks = "SELECT talk_id, week_of, name, phone, no_hosp, congr_id, theme_id, CONCAT (t.theme_id,' ',t.theme) AS Theme, local_sp 
		FROM talks
		INNER JOIN themes AS t
		USING ( theme_id )
		WHERE week_of = '$monday' AND outgoing = 0";
	$r_local_talks = mysqli_query ($dbc, $query_local_talks) OR die("MySQL error_local_talks: " . mysqli_error($dbc) . "<hr>\nQuery: $query_local_talks");
	$row_local_talks = mysqli_fetch_array($r_local_talks);
	$num_row_local_talks = mysqli_num_rows($row_local_talks);
	//$local = $row_local_talks['local_sp'];
        //echo $query_local_talks . '<br>';
    
	$query_out_talks = "SELECT talk_id, week_of, name, phone, no_hosp, congr_id, theme_id, CONCAT (t.theme_id,' ',t.theme) AS Theme, local_sp 
		FROM talks
		LEFT JOIN themes AS t
		USING ( theme_id )
		WHERE week_of = '$monday' AND local_sp = 1 AND outgoing = 1";
	$r_out_talks = mysqli_query ($dbc, $query_out_talks) OR die("MySQL error_visit_talks: " . mysqli_error($dbc) . "<hr>\nQuery: $query_out_talks");
	$row_out_talks = mysqli_fetch_array($r_out_talks);
	$num_row_out_talks = mysqli_num_rows($row_out_talks);
        //echo $query_out_talks;
	
	// Chairman query
	$row_chairman =& assign_record_exists($monday, 1, 2); //page_id = 1 AND assign_type_id = 2
	$num_row_chairman = mysqli_num_rows($row_chairman);

        // wtreader query
	$row_wtreader =& assign_record_exists($monday, 1, 4); //page_id = 1 AND assign_type_id = 4
	$num_row_wtreader = mysqli_num_rows($row_wtreader);

	// theme query
	$query_theme = "SELECT theme_id, t.theme AS theme
		FROM talks
		INNER JOIN themes AS t
		USING ( theme_id )
		WHERE week_of = '$monday'";
		
	$r_theme = mysqli_query ($dbc, $query_theme) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query_theme");
	$row_theme = mysqli_fetch_array($r_theme);	
	$num_row_theme = mysqli_num_rows($row_theme);

	//$row_theme =& assign_record_exists($monday, 1, 4); //page_id = 1 AND assign_type_id = 4
	//$num_row_theme = mysqli_num_rows($row_theme);
		
	// *** END Database query variables for forms select options ***
	require('db_close.php'); // Close the database connection.
	
	// *** Database query for visiting speakers

	// Assign current URL to a variable to use in the form action. This will include the GET date for the week of Monday...
	$page = $_SERVER['REQUEST_URI'];
	?>
	
		<table>
		
		<form action="<?php print $page; ?>" method="post">
				<tr>
				<td>Chairman:</td>
				<td>
				<select name="chairman" onchange="this.form.submit()">
				<?php
				if ($num_row_chairman = 1) {
					print '<option value="'.$row_chairman['user_id'].'" selected>'.$row_chairman['Name'].'</option>';
					while ($row2 = mysqli_fetch_array($r2)) {
						print '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
					}
				} else {
					while ($row2 = mysqli_fetch_array($r2)) {
						print '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
		</form>
		
						
		<form action="<?php print $page; ?>" method="post">
				<tr>
				<td>Watchtower Reader:</td>
				<td>
				<select name="wtreader" onchange="this.form.submit()">
				<?php
				if ($num_row_wtreader = 1) {
					print '<option value="'.$row_wtreader['user_id'].'" selected>'.$row_wtreader['Name'].'</option>';
					while ($row4 = mysqli_fetch_array($r4)) {
						print '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
					}
				} else {
					while ($row4 = mysqli_fetch_array($r4)) {
						print '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
		</form>
			<!--
			<tr>
			<td>Talk Theme: </td><td><?php print $theme; ?></td>
			</tr>
			<tr>
			<td>Article: </td><td><?php print $wt_study; ?></td>
			</tr>
			-->
		</table>
		
	<script type="text/javascript">
	
	function yesnoCheck() {
	    if (document.getElementById('yesCheck').checked) {
	        document.getElementById('localSpeaker').style.display = 'inline';
	        document.getElementById('visitSpeaker').style.display = 'none';
	    }
	    else document.getElementById('localSpeaker').style.display = 'none';
	    
	    if (document.getElementById('noCheck').checked) {
	        document.getElementById('localSpeaker').style.display = 'none';
	        document.getElementById('visitSpeaker').style.display = 'inline';
	    }
	    else document.getElementById('localSpeaker').style.display = 'inline';
	
	}
	
	function checkLocalSpeaker() {
		var chkBox = document.getElementById('local_speaker');
		if (chkBox.checked) {
			document.getElementById('visitSpeaker').style.display = 'none';
			document.getElementById('localSpeaker').style.display = 'inline';
			} else {
				document.getElementById('visitSpeaker').style.display = 'inline';
				document.getElementById('localSpeaker').style.display = 'none';
			}
		}	

	function checkOutSpeaker() {
		var chkBox = document.getElementById('out_speaker');
		if (chkBox.checked) {
			document.getElementById('OutGoing').style.display = 'inline';
			} else {
				document.getElementById('OutGoing').style.display = 'none';
			}
		}
		
		
	function checkOutSpeaker2() {
		var chkBox = document.getElementById('out_speaker_2');
		if (chkBox.checked) {
			document.getElementById('OutGoing2').style.display = 'inline';
			} else {
				document.getElementById('OutGoing2').style.display = 'none';
			}
		}

	function checkOutSpeaker3() {
		var chkBox = document.getElementById('out_speaker_3');
		if (chkBox.checked) {
			document.getElementById('OutGoing3').style.display = 'inline';
			} else {
				document.getElementById('OutGoing3').style.display = 'none';
			}
		}
					
	</script>
	
	<input type="checkbox" id="local_speaker" name="local_speaker" value="1" onclick="javascript:checkLocalSpeaker()" <?php if ($local == 1) {echo 'checked';} else {echo 'unchecked';} ?> /> Local Speaker?	
	
	<!--
	Local Speaker: 
	Yes <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck" <?php if ($local == 1) {echo 'checked';} ?> > 
	No <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" <?php if ($local == 0) {echo 'checked';} ?> ><br><br>	
	-->			

		<div id="visitSpeaker" <?php if ($local == 0) {echo 'style="display:inline"';} else {echo 'style="display:none"';} ?> >
		<form action="<?php print $page; ?>" method="post">
		<fieldset class="fieldset-auto-width">
		<legend>Visiting Speaker</legend>
		<table>
				<tr>
				<td>Name: </td><td><input type="text" name="visit_speaker" id="visit_speaker" size="25" maxsize="60" value="<?php if ($num_row_visit_talks = 1) {echo htmlentities($row_visit_talks['name']);
                                } else {
                                    echo '';
                                    } ?>" /></td>
				<td>Phone: </td><td><input type="text" name="visit_speaker_phone" id="visit_speaker_phone" size="15" maxsize="20" value="<?php if ($num_row_visit_talks = 1) {echo htmlentities($row_visit_talks['phone']);} else {echo '';} ?>" /></td>
				</tr>
				<tr>
				<td>Congregation: </td><td><select name="visit_cong" id="visit_cong" >
				<?php
				if ($num_row_visit_talks = 1) {
					print '<option value="'.$row_visit_talks['congr_id'].'" selected>'; if ($num_row_visit_talks = 1) {echo $row_visit_talks['Cong'];} else {echo '';} echo '</option>';
					while ($row8 = mysqli_fetch_array($r8)) {
						print '<option value="'.$row8['congr_id'].'">'.$row8['congregation'].'</option>';
					}
				} else {
					while ($row8 = mysqli_fetch_array($r8)) {
						print '<option value="'.$row8['congr_id'].'">'.$row8['congregation'].'</option>';
					}
				}
				?>				
				<td>No. for hospitality: </td><td><input type="text" name="visit_no_hosp" id="visit_no_hosp" size="4" maxsize="5" value="<?php if ($num_row_visit_talks = 1) {echo htmlentities($row_visit_talks['no_hosp']);} else {echo '';} ?>"/></td>
				</tr>
				</table>
				<table>
				<tr>
				<td>Theme: </td><td>&nbsp&nbsp&nbsp&nbsp&nbsp<select name="visit_theme" id="visit_theme" >
				<?php
				if ($num_row_visit_talks = 1) {
					print '<option value="'.$row_visit_talks['theme_id'].'" selected>'; if ($num_row_visit_talks = 1) {echo $row_visit_talks['Theme'];} else {echo '';} echo '</option>';
					while ($row3 = mysqli_fetch_array($r3)) {
						print '<option value="'.$row3['theme_id'].'">'.$row3['theme_id'].' '.$row3['theme'].'</option>';
					}
				} else {
					while ($row3 = mysqli_fetch_array($r3)) {
						print '<option value="'.$row3['theme_id'].'">'.$row3['theme_id'].' '.$row3['theme'].'</option>';
					}
				}
				?>
				</select></td>
				</tr><tr>
				<td><input type="submit" name="submit" value=" Submit " /></td>
				</tr>
		</table>
		</fieldset>		
		</form>
		</div>
	
		<div id="localSpeaker" <?php if ($local == 1) {echo 'style="display:inline"';} else {echo 'style="display:none"';} ?> >
		<form action="<?php print $page; ?>" method="post">
		<fieldset class="fieldset-auto-width">
		<legend>Local Speaker</legend>
		
			<table>
				<tr>
				<td>Speaker:</td>
				<td>
				<select name="localspeaker_sel" id="localspeaker_sel" >
				<?php 
				if ($num_row_speaker = 1) {
					print '<option value="'.$row_speaker['user_id'].'" selected>'; if ($num_row_speaker = 1) {echo $row_speaker['Name'];} else {echo '';} echo '</option>';
					while ($row1 = mysqli_fetch_array($r1)) {
						print '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
					}
				} else {
					while ($row1 = mysqli_fetch_array($r1)) {
						print '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
				<tr>
				<td>Theme: </td><td><select name="theme" >
				<?php
				if ($num_row_speaker = 1) {
					print '<option value="'.$row_speaker['theme_id'].'" selected>'; if ($num_row_speaker = 1) {echo $row_speaker['theme_id'] . ' ' . $row_speaker['Theme'];} else {echo '';} echo '</option>';
					while ($row5 = mysqli_fetch_array($r5)) {
						print '<option value="'.$row5['theme_id'].'">'.$row5['theme_id'].' '.$row5['theme'].'</option>';
					}
				} else {
					while ($row5 = mysqli_fetch_array($r5)) {
						print '<option value="'.$row5['theme_id'].'">'.$row5['theme_id'].' '.$row5['theme'].'</option>';
					}
				}
				?>
				</select></td>
				</tr><tr>
				<td><input type="submit" name="submit" value=" Submit " /></td>
				</tr>
			</table>
		</fieldset>		
		</form>
		</div>
		
		<input type="checkbox" id="out_speaker" name="out_speaker" value="1" onclick="javascript:checkOutSpeaker()" <?php if ($out_speaker == 1) {echo 'checked';} else {echo 'unchecked';} ?> /> Outgoing Speaker?
		
		<div id="OutGoing" <?php if ($out_speaker == 1) {echo 'style="display:inline"';} else {echo 'style="display:none"';} ?> >
		<form action="<?php print $page; ?>" method="post">
		<fieldset class="fieldset-auto-width">
		<legend>Outgoing Speaker</legend>
		<table>
				<tr>
				<tr>
				<td>Speaker:</td><td><select name="outspeaker" id="outspeaker" >
				<?php
				// If the query returns a record matching the date, assignment type and meeting, then use it for the selected option and also include the all the other names or else just show all the names in the option. Also the option assigns the user ID to its value, which is used in the POST check conditionals.
				if ($num_row_out_speaker = 1) {
					print '<option value="'.$row_out_speaker['user_id'].'" selected>'.$row_out_speaker['Name'].'</option>';
					while ($row6 = mysqli_fetch_array($r6)) {
						print '<option value="'.$row6['user_id'].'">'.$row6['Name'].'</option>';
					}
				} else {
					while ($row6 = mysqli_fetch_array($r6)) {
						print '<option value="'.$row6['user_id'].'">'.$row6['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
				<tr>
				<td>Congregation: </td><td><select name="out_cong" id="out_cong" >
				<?php
				if ($num_row_out_speaker = 1) {
					print '<option value="'.$row_out_speaker['congr_id'].'" selected>'; if ($num_row_out_speaker = 1) {echo $row_out_speaker['Cong'];} else {echo '';} echo '</option>';
					while ($row9 = mysqli_fetch_array($r9)) {
						print '<option value="'.$row9['congr_id'].'">'.$row9['congregation'].'</option>';
					}
				} else {
					while ($row9 = mysqli_fetch_array($r9)) {
						print '<option value="'.$row9['congr_id'].'">'.$row9['congregation'].'</option>';
					}
				}
				?>
				</tr>
				</table>
				<table>
				<tr>
				<td>Theme: </td><td>&nbsp&nbsp&nbsp&nbsp&nbsp<select name="out_theme" id="out_theme" >
				<?php
				if ($num_row_out_speaker = 1) {
					print '<option value="'.$row_out_speaker['theme_id'].'" selected>';  echo $row_out_speaker['theme_id'] . ' ' . $row_out_speaker['Theme']; echo '</option>';
					while ($row7 = mysqli_fetch_array($r7)) {
						print '<option value="'.$row7['theme_id'].'">'.$row7['theme_id'].' '.$row7['theme'].'</option>';
					}
				} else {
					while ($row7 = mysqli_fetch_array($r7)) {
						print '<option value="'.$row7['theme_id'].'">'.$row7['theme_id'].' '.$row7['theme'].'</option>';
					}
				}
				?>
				</select></td>
				</tr><tr>
				<td><input type="submit" name="submit" value=" Submit " /></td>
				</tr>
		</table>
		</fieldset>		
		</form>
		<input type="checkbox" id="out_speaker_2" name="out_speaker_2" value="1" onclick="javascript:checkOutSpeaker2()" <?php if ($out_speaker_2 == 1) {echo 'checked';} else {echo 'unchecked';} ?> /> Another Outgoing Speaker?
		</div>

		<div id="OutGoing2" <?php if ($out_speaker_2 == 1) {echo 'style="display:inline"';} else {echo 'style="display:none"';} ?> >
			<form action="<?php print $page; ?>" method="post">
			<fieldset class="fieldset-auto-width">
			<legend>2nd Outgoing Speaker</legend>
			<table>
					<tr>
					<tr>
					<td>Speaker:</td><td><select name="outspeaker2" id="outspeaker2" >
					<?php
					// If the query returns a record matching the date, assignment type and meeting, then use it for the selected option and also include the all the other names or else just show all the names in the option. Also the option assigns the user ID to its value, which is used in the POST check conditionals.
					if ($num_row_out_speaker_2 = 1) {
						print '<option value="'.$row_out_speaker_2['user_id'].'" selected>'.$row_out_speaker_2['Name'].'</option>';
						while ($row10 = mysqli_fetch_array($r10)) {
							print '<option value="'.$row10['user_id'].'">'.$row10['Name'].'</option>';
						}
					} else {
						while ($row10 = mysqli_fetch_array($r10)) {
							print '<option value="'.$row10['user_id'].'">'.$row10['Name'].'</option>';
						}
					}
					?>
					</select>
					</td>
					</tr>
					<tr>
					<td>Congregation: </td><td><select name="out_cong2" id="out_cong2" >
					<?php
					if ($num_row_out_speaker = 1) {
						print '<option value="'.$row_out_speaker_2['congr_id'].'" selected>'; if ($num_row_out_speaker = 1) {echo $row_out_speaker_2['Cong'];} else {echo '';} echo '</option>';
						while ($row11 = mysqli_fetch_array($r11)) {
							print '<option value="'.$row11['congr_id'].'">'.$row11['congregation'].'</option>';
						}
					} else {
						while ($row11 = mysqli_fetch_array($r11)) {
							print '<option value="'.$row11['congr_id'].'">'.$row11['congregation'].'</option>';
						}
					}
					?>
					</tr>
					</table>
					<table>
					<tr>
					<td>Theme: </td><td>&nbsp&nbsp&nbsp&nbsp&nbsp<select name="out_theme2" id="out_theme2" >
					<?php
					if ($num_row_out_speaker = 1) {
						print '<option value="'.$row_out_speaker_2['theme_id'].'" selected>';  echo $row_out_speaker_2['theme_id'] . ' ' . $row_out_speaker_2['Theme']; echo '</option>';
						while ($row12 = mysqli_fetch_array($r12)) {
							print '<option value="'.$row12['theme_id'].'">'.$row12['theme_id'].' '.$row12['theme'].'</option>';
						}
					} else {
						while ($row12 = mysqli_fetch_array($r12)) {
							print '<option value="'.$row12['theme_id'].'">'.$row12['theme_id'].' '.$row12['theme'].'</option>';
						}
					}
					?>
					</select></td>
					</tr><tr>
					<td><input type="submit" name="submit" value=" Submit " /></td>
					</tr>
			</table>
			</fieldset>		
			</form>
		<input type="checkbox" id="out_speaker_3" name="out_speaker_3" value="1" onclick="javascript:checkOutSpeaker3()" <?php if ($out_speaker_3 == 1) {echo 'checked';} else {echo 'unchecked';} ?> /> Third (Last) Outgoing Speaker?
		</div>
		
		<div id="OutGoing3" <?php if ($out_speaker_3 == 1) {echo 'style="display:inline"';} else {echo 'style="display:none"';} ?> >
		<form action="<?php print $page; ?>" method="post">
		<fieldset class="fieldset-auto-width">
		<legend>3rd Outgoing Speaker</legend>
		<table>
				<tr>
				<tr>
				<td>Speaker:</td><td><select name="outspeaker3" id="outspeaker3" >
				<?php
				// If the query returns a record matching the date, assignment type and meeting, then use it for the selected option and also include the all the other names or else just show all the names in the option. Also the option assigns the user ID to its value, which is used in the POST check conditionals.
				if ($num_row_out_speaker_3 = 1) {
					print '<option value="'.$row_out_speaker_3['user_id'].'" selected>'.$row_out_speaker_3['Name'].'</option>';
					while ($row13 = mysqli_fetch_array($r13)) {
						print '<option value="'.$row13['user_id'].'">'.$row13['Name'].'</option>';
					}
				} else {
					while ($row13 = mysqli_fetch_array($r13)) {
						print '<option value="'.$row13['user_id'].'">'.$row13['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
				<tr>
				<td>Congregation: </td><td><select name="out_cong" id="out_cong" >
				<?php
				if ($num_row_out_speaker_3 = 1) {
					print '<option value="'.$row_out_speaker_3['congr_id'].'" selected>'; if ($num_row_out_speaker_3 = 1) {echo $row_out_speaker_3['Cong'];} else {echo '';} echo '</option>';
					while ($row16 = mysqli_fetch_array($r16)) {
						print '<option value="'.$row16['congr_id'].'">'.$row16['congregation'].'</option>';
					}
				} else {
					while ($row16 = mysqli_fetch_array($r16)) {
						print '<option value="'.$row16['congr_id'].'">'.$row16['congregation'].'</option>';
					}
				}
				?>
				</tr>
				</table>
				<table>
				<tr>
				<td>Theme: </td><td>&nbsp&nbsp&nbsp&nbsp&nbsp<select name="out_theme" id="out_theme" >
				<?php
				if ($num_row_out_speaker_3 = 1) {
					print '<option value="'.$row_out_speaker_3['theme_id'].'" selected>';  echo $row_out_speaker_3['theme_id'] . ' ' . $row_out_speaker_3['Theme']; echo '</option>';
					while ($row14 = mysqli_fetch_array($r14)) {
						print '<option value="'.$row14['theme_id'].'">'.$row14['theme_id'].' '.$row14['theme'].'</option>';
					}
				} else {
					while ($row14 = mysqli_fetch_array($r14)) {
						print '<option value="'.$row14['theme_id'].'">'.$row14['theme_id'].' '.$row14['theme'].'</option>';
					}
				}
				?>
				</select></td>
				</tr><tr>
				<td><input type="submit" name="submit" value=" Submit " /></td>
				</tr>
		</table>
		</fieldset>		
		</form>
		</div>		
		
	<?php				
	print '<p class="error">';
	print $conflict_msg;
	print '</p>';
	// *** END Create the Forms. ***
	echo '
	<a href="edit_publicmeeting.php?monday=' . $prevw . '"><< Previous Week &nbsp&nbsp&nbsp&nbsp&nbsp</a>';
	if ($currw != $monday) {
		echo '<a href="edit_publicmeeting.php?monday=' . $currw . '">     This Week     </a>';
	}
	echo '<a href="edit_publicmeeting.php?monday=' . $nextw . '">&nbsp&nbsp&nbsp&nbsp&nbsp Next Week >></a>';
	//Include the footer:
	include('include/footer.html');
}
?>