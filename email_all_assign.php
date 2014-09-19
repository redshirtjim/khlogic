<?php // email_all_assign.php
// An email blast to all people with valid emails having assignments in next two weeks
require ('db_conn_sel.php'); // Database connection.
// Unless LIVE, use "AND (user_id IN (x,x,x,x))" where x = users who should recieve email for testing.	
$query0 = "SELECT DISTINCT user_id, CONCAT(u.first_name,' ', u.last_name) as 'Name', u.send_email
FROM assignments
INNER JOIN users AS u
USING ( user_id )
WHERE week_of >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) AND u.send_email = 1"; 
//  AND week_of <= DATE_ADD(CURDATE(),INTERVAL 15 DAY)	10,86,1,30,100,6    u.send_email = 1
$r0 = mysqli_query ($dbc, $query0) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query0");
//$row0 = mysqli_fetch_array($r0);
while ($row0 = mysqli_fetch_array($r0)) {
	$user_id = $row0['user_id'];
	$name = $row0['Name'];
	echo '<b>' . $user_id . '</b><br>';
	$query = "SELECT 
		week_of, 
		m.meeting_type AS Meeting, 
		at.assign_friendly_name AS 'Assignment', 
		c.cbs AS 'Cbs', 
		c.cbs_url AS 'Cbs_url',
		c.bible_read AS 'Bible_read', 
		c.no_1 AS 'No_1', 
		c.no_2 AS 'No_2', 
		c.no_2_source AS 'No_2_source', 
		c.no_2_url AS 'No_2_url', 
		c.no_3 AS 'No_3', 
		c.no_3_source AS 'No_3_source', 
		c.no_3_url AS 'No_3_url', 
		c.sm_1 AS 'Sm_1', 
		c.sm_2 AS 'Sm_2', 
		c.sm_3 AS 'Sm_3', 
		w.theme AS 'Theme_detail', 
		w.wt_study AS 'Article', 
		p.page AS 'Page', 
		p.page_id AS 'Page_id', 
		theme_id AS'Theme_id', 
		th.theme AS 'Theme', 
		n.congregation AS 'Congregation', 
		CONCAT(u.first_name,' ',u.last_name) as 'Name', 
		u.email AS 'Email', 
		user_id
		FROM assignments
		LEFT JOIN themes AS th
		USING ( theme_id ) 
		LEFT JOIN congregations AS n
		USING ( congr_id ) 
		LEFT JOIN assignment_type AS at
		USING ( assign_type_id ) 
		LEFT JOIN users AS u
		USING ( user_id ) 
		LEFT JOIN meeting_type AS m
		USING ( meeting_type_id ) 
		LEFT JOIN page AS p
		USING ( page_id ) 
		LEFT JOIN cts_detail AS c
		USING ( week_of ) 
		LEFT JOIN ptws_detail AS w
		USING ( week_of ) 
		WHERE user_id =  '$user_id'
		AND week_of >= DATE_SUB( CURDATE( ) , INTERVAL 6 
		DAY ) 
		ORDER BY week_of, Meeting";
	//  AND week_of <= DATE_ADD(CURDATE(),INTERVAL 15 DAY)
	$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
	//$row = mysqli_fetch_array($r);
	$num = mysqli_num_rows($r);
	if ($num > 0) {
	$email = '';
	$week_cat = '';	// A control variable.
	$msg = '';		// Empty the variable for the next go 'round.
	$msg .= '<br><p style="color:red;"><b>Please NOTE: NEW Feature - Hyperlink to source material for TMS parts! In both E-mail reminders and My Assignments!</b></p><p><b>Assignments for '.$row0['Name'].'</b></p><br>';
	while ($row = mysqli_fetch_array($r)) {
		$week = $row['week_of'];
		$date = date('F j, Y', strtotime($week));
		$meeting = $row['Meeting'];
		$assign = $row['Assignment'];
		$page = $row['Page'];
		$email = $row['Email'];
		$cbs = $row['Cbs'];
		$cbs_url = $row['Cbs_url'];
		$bible_read = trim(strip_tags($row['Bible_read']));
		$no_1 = trim(strip_tags($row['No_1']));
		$no_2 = $row['No_2'];
		$no_2_source = $row['No_2_source'];
		$no_2_url = $row['No_2_url'];
		$no_3 = $row['No_3'];
		$no_3_source = $row['No_3_source'];
		$no_3_url = $row['No_3_url'];
		$sm_1 = $row['Sm_1'];
		$sm_2 = $row['Sm_2'];
		$sm_3 = $row['Sm_3'];
		$theme_detail = $row['Theme_detail'];
		$article = $row['Article'];
		$page = $row['Page'];
		$page_id = $row['Page_id'];
		$theme_id = $row['Theme_id'];
		$theme = $row['Theme'];
		$congregation = $row['Congregation'];
		if($week != $week_cat) {	    //if its a new week date group, then start a new <ul>
	        if($week_cat != '') {		    //If it?s not the firt occurance of the same week, close previous one
		        $msg .= "</ul>\n";
	        }
	        $msg .= '<b>' . $date . '</b>';// start the new <ul>
	        $msg .= '<ul>';
	    }
	    // create the assignment items in a table after each week date group
		$msg .= '<table><tr>';
		if ($assign == 'Sound Panel' OR $assign == 'Stage' OR $assign == 'Microphone' OR $assign == 'Attendant') {
			$msg .= '<td valign="top">' . $meeting . ': </td>';
			$msg .= '<td valign="top">' . $assign . '</td>';
		} else {
			$msg .= '<td valign="top"><b>' . $page . ': </b></td>';
			$msg .= '<td valign="top"><b>' . $assign . '</b></td>';
		}
		if ($assign == 'Reader' AND $meeting == 'Congregation Bible Study') {
			$assign_detail = '<a href="' . $cbs_url . '" target="_blank">' . $cbs . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Bible highlights') {
			$assign_detail = '<a href="http://wol.jw.org/en/wol/l/r1/lp-e?q=' . $bible_read . '">' . $bible_read . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Talk No. 1') {
			$assign_detail = '<a href="http://wol.jw.org/en/wol/l/r1/lp-e?q=' . $no_1 . '">' . $no_1 . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Talk No. 2') {
			$assign_detail = '<a href="' . $no_2_url . '" target="_blank">' . $no_2 . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
			$query = "SELECT CONCAT(u.first_name,' ',u.last_name) as 'Name', u.phone_1 AS Phone, st.study AS Study, se.setting AS Setting
			FROM assignments AS a
			INNER JOIN users AS u
			USING ( user_id )
			LEFT JOIN studies as st
			USING ( study_id )
			LEFT JOIN settings as se
			USING ( setting_id )
			WHERE week_of = '$week' AND assign_type_id = 33";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			$row = mysqli_fetch_array($r);
			$query1 = "SELECT CONCAT(st.study_id, ' ', st.study) AS Study, CONCAT(se.setting_id, ' ', se.setting) AS Setting
			FROM assignments AS a
			LEFT JOIN studies as st
			USING ( study_id )
			LEFT JOIN settings as se
			USING ( setting_id )
			WHERE week_of = '$week' AND assign_type_id = 9";
			$r1 = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row1 = mysqli_fetch_array($r1);			
			$num = mysqli_num_rows($r1);
			if ($num > 0) {
				$speaker = $row1['Name'];
				$phone = $row1['Phone'];
				$study = $row1['Study'];
				$setting = $row1['Setting'];
				$msg .= '<tr><td></td><td></td><td valign="top">Assistant: ' . $speaker . ' ' . $phone . '</td></tr>';
				$msg .= '<tr><td></td><td></td><td valign="top">Study: ' . $study . '</td></tr>';
				$msg .= '<tr><td></td><td></td><td valign="top">Setting: ' . $setting . '</td></tr>';
			}
		}
		if ($assign == 'No. 2 Householder') {
			$assign_detail = $no_2;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
			$query = "SELECT CONCAT(u.first_name,' ',u.last_name) as 'Name', u.phone_1 AS Phone
			FROM assignments AS a
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week' AND assign_type_id = 9";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			$row = mysqli_fetch_array($r);
			$num = mysqli_num_rows($r);
			if ($num > 0) {
				$speaker = $row['Name'];
				$phone = $row['Phone'];
				$msg .= '<tr><td></td><td></td><td valign="top">Your speaker: ' . $speaker . ' ' . $phone . '</td></tr>';
			}
		}
		if ($assign == 'Talk No. 3') {
			$assign_detail = '<a href="' . $no_3_url . '" target="_blank">' . $no_3 . '</a>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
			$query = "SELECT CONCAT(u.first_name,' ',u.last_name) as 'Name', u.phone_1 AS Phone, st.study AS Study, se.setting AS Setting
			FROM assignments AS a
			INNER JOIN users AS u
			USING ( user_id )
			LEFT JOIN studies as st
			USING ( study_id )
			LEFT JOIN settings as se
			USING ( setting_id )
			WHERE week_of = '$week' AND assign_type_id = 34";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			$row = mysqli_fetch_array($r);
			$query1 = "SELECT CONCAT(st.study_id, ' ', st.study) AS Study, CONCAT(se.setting_id, ' ', se.setting) AS Setting
			FROM assignments AS a
			LEFT JOIN studies as st
			USING ( study_id )
			LEFT JOIN settings as se
			USING ( setting_id )
			WHERE week_of = '$week' AND assign_type_id = 10";
			$r = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row = mysqli_fetch_array($r);			
			$num = mysqli_num_rows($r);
			if ($num > 0) {
				$speaker = $row['Name'];
				$phone = $row['Phone'];
				$study = $row['Study'];
				$setting = $row['Setting'];
				$msg .= '<tr><td></td><td></td><td valign="top">Your householder: </td><td>' . $speaker . '</td><td>' . $phone . '</td></tr>';
				$msg .= '<tr><td></td><td></td><td valign="top">Study: ' . $study . '</td></tr>';
				$msg .= '<tr><td></td><td></td><td valign="top">Setting: ' . $setting . '</td></tr>';
			}
		}
		if ($assign == 'No. 3 Householder') {
			$assign_detail = $no_3;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
			$query = "SELECT CONCAT(u.first_name,' ',u.last_name) as 'Name', u.phone_1 AS Phone
			FROM assignments AS a
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week' AND assign_type_id = 10";
			$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
			$row = mysqli_fetch_array($r);
			$num = mysqli_num_rows($r);
			if ($num > 0) {
				$speaker = $row['Name'];
				$phone = $row['Phone'];
				$msg .= '<tr><td></td><td></td><td valign="top">Your speaker: ' . $speaker . ' ' . $phone . '</td></tr>';
			}
		}	
		if ($assign == 'No. 1') {
			$assign_detail = $sm_1;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'No. 2') {
			$assign_detail = $sm_2;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'No. 3') {
			$assign_detail = $sm_3;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Public Speaker') {
			$assign_detail = $theme;
			$cong = $congregation;
			$talk_no = $theme_id;
			$msg .= '<td valign="top"><b>- ' . $cong . ' Cong.,</b></td>';
			$msg .= '<td valign="top"><b> #' . $talk_no . '</b></td>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Outgoing Speaker') {
			$assign_detail = $theme;
			$cong = $congregation;
			$talk_no = $theme_id;
			$msg .= '<td valign="top"><b>- ' . $cong . ' Cong.,</b></td>';
			$msg .= '<td valign="top"><b> #' . $talk_no . '</b></td>';
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}
		if ($assign == 'Reader' AND $meeting == 'Public Meeting') {
			$assign_detail = $article;
			$msg .= '<td valign="top"><b><i>' . wordwrap($assign_detail, 80, "<br>") . '</i></b></td>';
		}	
		$msg .= '</tr></table>';
				
		$week_cat = $week;		//Assign the value of actual category for the next time in the loop
        }
    }
	$msg .= "</ul>\n";
	$msg .= '<a href="http://khlogic.org" >Kingdom Hall Logic</a>';
        //$sub_date = date('m/d/y');
	// SEND emails
	$to = $email;
	$subject = 'KH Assignment(s) (E-mail sent on ' . date('m/d/y') . ')';
        //$subject .= $sub_date; 
	$body = $msg;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: assignments@khlogic.org";
	mail($to, $subject, $body, $headers);
	echo $msg . '<br>';
	echo 'E-mail sent to ' . $email . '<br><br><br>';
	$msg_admin .= $email . '<br>';
}
$to_admin = 'jimrush72@gmail.com';
$subject_admin = 'Assignment E-mails were sent to:';
$body_admin = $msg_admin;
$headers_admin  = 'MIME-Version: 1.0' . "\r\n";
$headers_admin .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers_admin .= "From: khlogic@redshirt-webdev.info";
mail($to_admin, $subject_admin, $body_admin, $headers_admin);
require ('db_close.php'); // Close the database connection.
?>