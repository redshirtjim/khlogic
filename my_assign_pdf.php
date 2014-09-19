<?php //my_assign.php
// A report of upcoming assignments based on user e-mail address / user_id
session_start();
include('include/functions.inc.php');

$assign =& my_assignments();

require('tcpdf/tcpdf.php');

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('dejavusans','',10);
$pdf->WriteHTML($assign);
$pdf->Output('my_assignments.pdf');

?>