<?php // - people.php
//Admin page used to add, edit, and delete publishers.
session_start();

// *** First, check if user has permission to view the page ***
//require ('include/config.inc.php');
require ('db_conn_sel.php');

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

$query = "SELECT admin, public, cbs, tms, service_meet, attendants, sound_stage, cleaning, grounds FROM users WHERE user_id = $user_id AND email = '$email'";

$r = mysqli_query ($dbc, $query) OR die("MySQL errOR: " . mysqli_errOR($dbc) . "<hr>\nQuery: $query");

$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);

if ($row['admin'] == FALSE) {
	redirect_user('index.php');
	// Close the connection.
	require('db_close.php');
} else { // *** END permission check ***
		
	//Include the header:
	//require ('include/config.inc.php'); // Require the config
	include('include/header.html');
	echo 'Publishers';
	echo '<p align="right"><a href="add_person.php"><img src="img/add.ico" width="12" height="12">Manually add a publisher</a></p>';
	//echo '<p>Publisher List</p>';

	
	// Connect and select:
	include('db_conn_sel.php');
	
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" align="right">
	<input name="searchquery" type="text" size="15" maxlength="50" value="<?php echo $_POST['searchquery']; ?>" />
	<input name="myBtn" type="submit" value=" Search ">
	<br /><br />
	</form>
	<div>
	<?php echo $search_output; ?>
	</div>
	
	<?php
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['searchquery'] != ""){
		echo '<p align="right"><a href="people.php">Reset</a></p>';
		$search_output = "";
		$searchquery = preg_replace('#[^a-z 0-9?!]#i', '', $_POST['searchquery']);
		$query = "SELECT user_id, p.last_name AS 'Last Name', p.first_name, CONCAT(p.gender,' ',p.first_name) AS 'First Name', pt.pub_type AS  'Publisher Type', st.servant_type AS  'Servant Type', p.email AS Email, p.phone_1, p.phone_2
		FROM users AS p
		INNER JOIN servant_type AS st
		USING ( servant_type_id ) 
		INNER JOIN pub_type AS pt
		USING ( pub_type_id )
		WHERE p.last_name LIKE '%$searchquery%' OR p.first_name LIKE '%$searchquery%'";
		
		$r = mysqli_query ($dbc, $query) or die(mysqli_error());
		$count = mysqli_num_rows($r);
		
		if($count > 0){
			echo '
			<hr />
			<table align="center" cellspacing="0" cellpadding="0" width="100%">
			<tr><td align="left"><b> </b></td>
			<td align="left"><b><a href="people.php?sort=fn">First Name</a></b></td>
			<td align="left"><b><a href="people.php?sort=ln">Last Name</a></b></td>
			<td align="left"><b>Publisher Type</b></td>
			<td align="left"><b>Servant Type</b></td>';
			//Set alternate background for each row
			$bg = '#eeeeee'; //Set initial background color
			// Fetch and print all the records:
			while ($row = mysqli_fetch_array($r)) {
				$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //Switch the background color
				echo '<tr bgcolor="' . $bg . '">
				<td align="left"><a href=display_person.php?user_id=' . $row['user_id'] . '><img src="img/eye.ico" width="12" height="12"></a></td>
				<td align="left">' . $row['First Name'] . '</td>
				<td align="left">' . $row['Last Name'] . '</td>
				<td align="left">' . $row['Publisher Type'] . '</td>
				<td align="left">' . $row['Servant Type'] . '</td>
				</tr>';
			} //End of While Loop
			echo '</table><hr />'; // Close the table.
		} else {
			echo '<hr />0 results for <strong>' . $searchquery . '</strong><hr />';
		}
	}		
	
	// Number of records to show per page:
	$display = 10;
		$q = "SELECT COUNT(user_id) FROM users";
		$r = @mysqli_query ($dbc, $q);
		$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
		$records = $row[0];
	
		// Determine how many pages there are...
	if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
		$pages = $_GET['p'];
	} else { // Need to determine.
	 	// Count the number of records:
		$q = "SELECT COUNT(user_id) FROM users";
		$r = @mysqli_query ($dbc, $q);
		$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
		$records = $row[0];
		// Calculate the number of pages...
		if ($records > $display) { // More than 1 page.
			$pages = ceil ($records/$display);
		} else {
			$pages = 1;
		}
	} // End of p IF.
	
	// Determine where in the database to start returning results...
	if (isset($_GET['s']) && is_numeric($_GET['s'])) {
		$start = $_GET['s'];
	} else {
		$start = 0;
	}
	
	// Determine the sort...
	// Default is by registration date.
	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';
	
	// Determine the sorting order:
	switch ($sort) {
		case 'ln':
			$order_by = 'last_name ASC';
			break;
		case 'fn':
			$order_by = 'first_name ASC';
			break;
		default:
			$order_by = 'last_name ASC';
			$sort = 'ln';
			break;
	}

		// Define the query:
	$query = "SELECT user_id, p.last_name AS 'Last Name', CONCAT(p.gender,' ',p.first_name) AS 'First Name', pt.pub_type AS  'Publisher Type', st.servant_type AS  'Servant Type', p.email AS Email, p.phone_1, p.phone_2
		FROM users AS p
		INNER JOIN servant_type AS st
		USING ( servant_type_id ) 
		INNER JOIN pub_type AS pt
		USING ( pub_type_id ) 
		ORDER BY $order_by LIMIT $start, $display";
		
	$r = mysqli_query ($dbc, $query); // Run the query.
	
	// Count the number of returned rows:
	$num = mysqli_num_rows($r);	
	
	if ($num > 0) { // If it ran OK, display the records.
		// Print how many users there are:
		//echo "<p>Showing $num of $records</p>\n";
	
		// Table header.
?>		
		<div id="ifNo" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['searchquery'] != "") {echo 'style="visibility:hidden"';} else {echo 'style="visibility:visible"';} ?> >
		
		<table align="center" cellspacing="0" cellpadding="0" width="100%">
			<tr><td align="left"><b> </b></td>
			<td align="left"><b><a href="people.php?sort=fn">First Name</a></b></td>
			<td align="left"><b><a href="people.php?sort=ln">Last Name</a></b></td>
			<td align="left"><b>Publisher Type</b></td>
			<td align="left"><b>Servant Type</b></td>
<?php		
		//Set alternate background for each row
		$bg = '#eeeeee'; //Set initial background color
		// Fetch and print all the records:
		while ($row = mysqli_fetch_array($r)) {
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee'); //Switch the background color
			print '<tr bgcolor="' . $bg . '">
			<td align="left"><a href=display_person.php?user_id=' . $row['user_id'] . '><img src="img/eye.ico" width="12" height="12"></a></td>
			<td align="left">' . $row['First Name'] . '</td>
			<td align="left">' . $row['Last Name'] . '</td>
			<td align="left">' . $row['Publisher Type'] . '</td>
			<td align="left">' . $row['Servant Type'] . '</td>
			</tr>';
			} //End of While Loop
			print '</table>'; // Close the table.
			
	
	} else { // Query didnt run.
		print '<p style="color: red;">Could not retrieve the data because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
		print 'Or because there are no rows in the table';
	} // End of query IF.
	
	// Close the connection.
	mysqli_free_result ($r); // Free up the resources.
	mysqli_close($dbc);
	
	// Make the links to other pages, if necessary.
	if ($pages > 1) {
		
		echo '<br /><p>';
		$current_page = ($start/$display) + 1;
		
		// If it's not the first page, make a Previous button:
		if ($current_page != 1) {
			echo '<a href="people.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
		}
		
		// Make all the numbered pages:
		for ($i = 1; $i <= $pages; $i++) {
			if ($i != $current_page) {
				echo '<a href="people.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
			} else {
				echo $i . ' ';
			}
		} // End of FOR loop.
		
		// If it's not the last page, make a Next button:
		if ($current_page != $pages) {
			echo '<a href="people.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
		}
		
		echo '</p>'; // Close the paragraph.
		echo '</div>';	
		
	} // End of links section.
}


//Include the footer:
include('include/footer.html');
?>