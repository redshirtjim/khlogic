<?php //my_assign.php A report of upcoming assignments based on user e-mail address / user_id
session_start();
include('include/header.html');
require ('include/functions.inc.php');

//my_assignments();
$msg =& my_assignments();
echo $msg;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// Trim all the incoming data:
	//$trimmed = array_map('trim', $_POST);
	// Check for an email address:
	//if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
	//$email = mysqli_real_escape_string ($dbc, $trimmed['email']);
		
		//$to = $trimmed['email'];
		$to = $_SESSION['email'];
		$subject = 'Assignment(s)';
		$body = $msg;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: khlogic@redshirt-webdev.info";
		mail($to, $subject, $body, $headers);
		echo 'E-mail sent to ' . $_SESSION['email'] . '.';
	//} else {
	//	echo '<p class="error">Please enter a valid email address!</p>';
	//}
}
?>
<form action="my_assign.php" method="post">
<!--	<table>
	<tr>
	<td><p class="form">Email My Assignments:</p></td>
	<td><input type="email" name="email" size="25" value="" /></td>
	</tr>
	</table>
	
	<p><input type="submit" name="submit" value=" Send to My E-mail " /></p>-->
	<a><input type="image" src="img/envelope.png" height="20px" onsubmit="submit-form();"></a>
	<a href="my_assign_pdf.php" target="blank"><span class="glyphicon glyphicon-file"></span></a>
	
</form>
<?php

//echo '<a href="my_assign_pdf.php" target="blank"><img src="img/pdf.ico" width="50" height="50"></a>';

require ('db_close.php'); // Close the database connection.

	//Include the footer:
	include('include/footer.html');

?>