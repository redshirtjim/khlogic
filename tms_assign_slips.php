<?php //tms_assign_slips.php
session_start();
header('Content-Type: text/html; charset=utf-8');
// generate a pdf version tms assignment slips
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$start = $_GET['start_slip'];
require ('db_conn_sel.php'); // Database connection.

$query = "SELECT week_of, m.meeting_type AS Meeting, assign_type_id, at.assign_short_name AS  'Assignment', c.bible_read AS Bible_read, c.no_1 AS No1, c.no_2 AS No2, c.no_2_source AS No2Source, c.no_3 AS No3, c.no_3_source AS No3Source, page_id, p.page, p.page_id, study_id, st.study AS Study, setting_id, se.setting AS Setting, CONCAT(u.first_name, ' ', u.last_name) AS Name, u.gender AS Gender
		FROM assignments
		INNER JOIN themes AS th
		USING ( theme_id ) 
		LEFT JOIN congregations AS n
		USING ( congr_id ) 
		INNER JOIN assignment_type AS at
		USING ( assign_type_id ) 
		INNER JOIN users AS u
		USING ( user_id ) 
		INNER JOIN meeting_type AS m
		USING ( meeting_type_id ) 
		INNER JOIN page AS p
		USING ( page_id ) 
		INNER JOIN cts_detail AS c
		USING ( week_of ) 
		INNER JOIN ptws_detail AS w
		USING ( week_of ) 
		LEFT JOIN studies as st
		USING ( study_id )
		LEFT JOIN settings as se
		USING ( setting_id )
		WHERE page_id = 3
		AND week_of >= '$start' 
		ORDER BY week_of, assign_type_id";

$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");


require('fpdf/fpdf.php');
$pdf = new FPDF('L', 'mm', array(152.4,101.6));

while ($row = mysqli_fetch_array($r)) {
	$assign_type_id = $row['assign_type_id'];
	$name = $row['Name'];
	$week_of = $row['week_of'];
	$date = date('n/j/Y', strtotime($week_of));
	$talk = $row['Assignment'];
	$gender = $row['Gender'];
	if ($row['setting_id'] > 0) {
		$setting = $row['setting_id'];
	} else {
		$setting = '';
	}
	if ($row['study_id'] > 0) {
		$study = $row['study_id'];
	} else {
		$study = '';
	}	
	$material = '';
	$theme = '';

	if ($assign_type_id == 7) {
		$material = stripslashes($row['Bible_read']);	
		$material = iconv('UTF-8', 'windows-1252', $material); // stripslashes and iconv to deal with utf-8 characters like ¶
	}
	if ($assign_type_id == 8 OR $assign_type_id == 11) {
		$material = stripslashes($row['No1']);
		$material = iconv('UTF-8', 'windows-1252', $material); // stripslashes and iconv to deal with utf-8 characters like ¶
	}
	if ($assign_type_id == 9 OR $assign_type_id == 12 OR $assign_type_id == 33 OR $assign_type_id == 35) {
		$material = stripslashes($row['No2Source']);
		$material = iconv('UTF-8', 'windows-1252', $material); // stripslashes and iconv to deal with utf-8 characters like ¶
		$theme = $row['No2'];
	}
	if ($assign_type_id == 10 OR $assign_type_id == 13 OR $assign_type_id == 34 OR $assign_type_id == 36) {
		$material = stripslashes($row['No3Source']);
		$material = iconv('UTF-8', 'windows-1252', $material); // stripslashes and iconv to deal with utf-8 characters like ¶
		$theme = $row['No3'];
	}
	
	if ($assign_type_id == 7 OR $assign_type_id == 8 OR $assign_type_id == 9 OR $assign_type_id == 10 OR $assign_type_id == 33 OR $assign_type_id == 34) {
		$x = '70.5';
		$y = '47.5';
	}
	if ($assign_type_id == 11 OR $assign_type_id == 12 OR $assign_type_id == 13 OR $assign_type_id == 35 OR $assign_type_id == 36) {
		$x = '93';
		$y = '47.5';
	}
	if ($assign_type_id == 14 OR $assign_type_id == 15 OR $assign_type_id == 16 OR $assign_type_id == 37 OR $assign_type_id == 38) {
		$x = '10';
		$y = '10';
	}
	
	if ($gender == 'Sr.') {
		
		// Main school sisters
		if ($assign_type_id == 9) {
			
			$query1 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS AsstName, u.phone_1 AS Phone
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 33";
			
			$r1 = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row1 = mysqli_fetch_array($r1);
			$asst_name = $row1['AsstName'] . ' ' . $row1['Phone'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(25,20,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->Text(31,29,$asst_name);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 33) {
			
			$query2 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS SpName
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 9";
			
			$r2 = mysqli_query ($dbc, $query2) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query2");
			$row2 = mysqli_fetch_array($r2);
			$sp_name = $row2['SpName'];
									
			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','',11);
			$pdf->Text(25,20,$sp_name);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(31,29,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 10) {
			
			$query1 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS AsstName, u.phone_1 AS Phone
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 34";
			
			$r1 = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row1 = mysqli_fetch_array($r1);
			$asst_name = $row1['AsstName'] . ' ' . $row1['Phone'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(25,20,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->Text(31,29,$asst_name);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 34) {
			
			$query2 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS SpName
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 10";
			
			$r2 = mysqli_query ($dbc, $query2) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query2");
			$row2 = mysqli_fetch_array($r2);
			$sp_name = $row2['SpName'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','',11);
			$pdf->Text(25,20,$sp_name);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(31,29,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		// Second school sisters
		if ($assign_type_id == 12) {
			
			$query1 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS AsstName, u.phone_1 AS Phone
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 35";
			
			$r1 = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row1 = mysqli_fetch_array($r1);
			$asst_name = $row1['AsstName'] . ' ' . $row1['Phone'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(25,20,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->Text(31,29,$asst_name);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 35) {
			
			$query2 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS SpName
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 12";
			
			$r2 = mysqli_query ($dbc, $query2) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query2");
			$row2 = mysqli_fetch_array($r2);
			$sp_name = $row2['SpName'];
									
			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','',11);
			$pdf->Text(25,20,$sp_name);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(31,29,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 13) {
			
			$query1 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS AsstName, u.phone_1 AS Phone
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 36";
			
			$r1 = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row1 = mysqli_fetch_array($r1);
			$asst_name = $row1['AsstName'] . ' ' . $row1['Phone'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(25,20,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->Text(31,29,$asst_name);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 36) {
			
			$query2 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS SpName
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 13";
			
			$r2 = mysqli_query ($dbc, $query2) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query2");
			$row2 = mysqli_fetch_array($r2);
			$sp_name = $row2['SpName'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','',11);
			$pdf->Text(25,20,$sp_name);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(31,29,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}		
		// Third school sisters
		if ($assign_type_id == 15) {
			
			$query1 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS AsstName, u.phone_1 AS Phone
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 37";
			
			$r1 = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row1 = mysqli_fetch_array($r1);
			$asst_name = $row1['AsstName'] . ' ' . $row1['Phone'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(25,20,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->Text(31,29,$asst_name);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 37) {
			
			$query2 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS SpName
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 15";
			
			$r2 = mysqli_query ($dbc, $query2) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query2");
			$row2 = mysqli_fetch_array($r2);
			$sp_name = $row2['SpName'];
									
			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','',11);
			$pdf->Text(25,20,$sp_name);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(31,29,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 16) {
			
			$query1 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS AsstName, u.phone_1 AS Phone
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 38";
			
			$r1 = mysqli_query ($dbc, $query1) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query1");
			$row1 = mysqli_fetch_array($r1);
			$asst_name = $row1['AsstName'] . ' ' . $row1['Phone'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(25,20,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->Text(31,29,$asst_name);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}
		if ($assign_type_id == 38) {
			
			$query2 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS SpName
			FROM assignments
			INNER JOIN users AS u
			USING ( user_id )
			WHERE week_of = '$week_of' AND assign_type_id = 16";
			
			$r2 = mysqli_query ($dbc, $query2) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query2");
			$row2 = mysqli_fetch_array($r2);
			$sp_name = $row2['SpName'];

			$pdf->AddPage();
			$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
			$pdf->SetFont('Times','',11);
			$pdf->Text(25,20,$sp_name);
			$pdf->Text(104,20,$talk);
			$pdf->Text(124,20,$date);
			$pdf->SetFont('Times','B',11);
			$pdf->Text(31,29,$name);
			$pdf->SetFont('Times','',11);
			$pdf->Text(29,47,$setting);
			$pdf->Text(89,60,$study);
			$pdf->SetXY(103,26);
			$pdf->MultiCell(40,4.5,$material);
			$pdf->SetXY(25,35);
			$pdf->MultiCell(115,4.5,$theme);
			$pdf->SetFont('ZapfDingbats','',11);
			$pdf->Text($x,$y,'3');
		}		
						
	} else {	//Brothers:
		
		$pdf->AddPage();
		$pdf->Image('img/assign_slip.jpg',0,0,152.4,101.6,JPG);
		$pdf->SetFont('Times','',11);
		$pdf->Text(25,20,$name);
		$pdf->Text(104,20,$talk);
		$pdf->Text(124,20,$date);
		$pdf->Text(29,47,$setting);
		$pdf->Text(89,60,$study);
		$pdf->SetXY(103,26);
		$pdf->MultiCell(40,4.5,$material);
		$pdf->SetXY(25,35);
		$pdf->MultiCell(115,4.5,$theme);
		$pdf->SetFont('ZapfDingbats','',11);
		$pdf->Text($x,$y,'3');

	}
}
}

$pdf->Output();

?>