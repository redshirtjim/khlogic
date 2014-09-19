<?php // add_person.php Admin page used to add, edit, and delete publishers.
session_start();
include('include/header.html');																			//Include the header
require ('include/config.inc.php');
require ('model/data_functions.php');
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$admin_auth =& admin_auth($user_id, $email);															// *** First, check if user has permission to view the page ***
$add_another = '';
if ($admin_auth == 0) {
	require('include/login_funcitions.inc.php');
	redirect_user('index.php');
	require(CLSMYSQL);																					// Close the connection
} else {																								// *** END permission check ***
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {															// Handle the form
		require (MYSQL);																				// Connect and select
		$problem = FALSE; 																				// Validate the form data
		if (!empty($_POST['gender']) && !empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['email']) && !empty($_POST['pub_type_id'])) {
			$gender = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['gender'])));
			$f_name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['f_name'])));
			$l_name = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['l_name'])));
			$email = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['email'])));
			$phone1 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['phone1'])));
			$phone2 = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['phone2'])));
			$pub_type_id = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['pub_type_id'])));
			$servant_type_id = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['servant_type_id'])));
			if (isset($_POST['public_speaker'])){$public_speaker=1;} else {$public_speaker=0;};
			if (isset($_POST['chairman'])){$chairman=1;} else {$chairman=0;};
			if (isset($_POST['reader'])){$reader=1;} else {$reader=0;};
			if (isset($_POST['overseer'])){$overseer=1;} else {$overseer=0;};
			if (isset($_POST['prayer'])){$prayer=1;} else {$prayer=0;};
			if (isset($_POST['bible_high'])){$bible_high=1;} else {$bible_high=0;};
			if (isset($_POST['no_1'])){$no_1=1;} else {$no_1=0;};
			if (isset($_POST['no_2'])){$no_2=1;} else {$no_2=0;};
			if (isset($_POST['no_3'])){$no_3=1;} else {$no_3=0;};
			if (isset($_POST['householder'])){$householder=1;} else {$householder=0;};
			if (isset($_POST['serv_meet'])){$serv_meet=1;} else {$serv_meet=0;};
			if (isset($_POST['attend'])){$attend=1;} else {$attend=0;};
			if (isset($_POST['sound_panel'])){$sound_panel=1;} else {$sound_panel=0;};
			if (isset($_POST['stage'])){$stage=1;} else {$stage=0;};
			if (isset($_POST['mic'])){$mic=1;} else {$mic=0;};
			if (isset($_POST['grounds_keeper'])){$grounds_keeper=1;} else {$grounds_keeper=0;};
		} else {
			print '<p style="color: red;">Please submit data for all fields.</p>';
			$problem = TRUE;
		}
		if (!$problem) {																					
			$add_person_relpy =& add_person($gender, $f_name, $l_name, $email, $phone1, $phone2, $pub_type_id, $servant_type_id, $public_speaker, $chairman, $reader, $overseer, $prayer, $bible_high, $no_1, $no_2, $no_3, $serv_meet, $attend, $sound_panel, $stage, $mic, $grounds_keeper, $householder);	// Define the query in data_functions.php
			if ($add_person_relpy == 1) {
				$add_another = '<p>Publisher has been added. Add another...</p>';
			} else {
				$add_another = '<p style="color: red;">Could not add the entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $pub_insert_query . '</p>';
			}
		}																									// No problem!
	}
} 																											// End of form submission IF
include('view/form_add_person.html');
include('include/footer.html');																				//Include the footer
?>