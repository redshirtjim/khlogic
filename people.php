<?php // - people.php Admin page to view the publishers table, search by name. Links to add, edit, and delete publishers.
session_start();
include ('include/header.html');																		//Include the header
require ('model/data_functions.php');
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$admin_auth =& admin_auth($user_id, $email);															// *** First, check if user has permission to view the page ***
if ($admin_auth == 0) {
	require ('include/login_functions.inc.php');
	redirect_user('index.php');
} else {																								// *** END permission check ***
	include ('view/form_people_control.html');
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['searchstring'] != ""){							// User has option to search for a person
		$searchstring = preg_replace('#[^a-z 0-9?!]#i', '', $_POST['searchstring']);
		$r =& people_search($searchstring);																// Search query from people_search() function
		$count = mysqli_num_rows($r);
		if($count > 0){
			echo '<p align="right"><a href="people.php">Reset</a></p>';
			include ('view/form_people_table_header.html');
			while ($row = mysqli_fetch_array($r)) {
				$found_user_id = $row['user_id'];
				$first_name = $row['First Name'];
				$last_name = $row['Last Name'];
				$publisher_type = $row['Publisher Type'];
				$servant_type = $row['Servant Type'];
				include ('view/form_people_table.html');
			}
			echo '</table></div>';																		// This table and div begin in 'view/form_people_table_header.html'
		} else {
			echo '0 results for <strong>' . $searchstring . '</strong>';
		}
	} else {																							// If search function is not used, then just show everyone with pagination.
		$count =& count_people();																		// This first query is just to get the total count of rows
		$page_rows = 7;																					// This is the number of results we want displayed per page
		$last = ceil($count/$page_rows);																// This tells us the page number of our last page
		if($last < 1){																					// This makes sure $last cannot be less than 1
			$last = 1;
		}
		$pagenum = 1;																					// Establish the $pagenum variable
		if(isset($_GET['pn'])){																			// Get pagenum from URL vars if it is present, else it is = 1
			$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
		}
		if ($pagenum < 1) {																				// This makes sure the page number isn't below 1, or more than our $last page
		    $pagenum = 1; 
		} else if ($pagenum > $last) { 
		    $pagenum = $last; 
		}
		$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;								// This sets the range of rows to query for the chosen $pagenum
		$people =& all_people($limit);																	// This is your query again, it is for grabbing just one page worth of rows by applying $limit
		$paginationCtrls = '';																			// Establish the $paginationCtrls variable
		if($last != 1){																					// If there is more than 1 page worth of results
			if ($pagenum > 1) {																			/* First we check if we are on page one. If we are then we don't need a link to 																	the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page. */
		        $previous = $pagenum - 1;
				$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'"><span class="glyphicon glyphicon-backward"></a> &nbsp; &nbsp; ';
				for($i = $pagenum-4; $i < $pagenum; $i++){												// Render clickable number links that should appear on the left of the target page 																		number
					if($i > 0){
				        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
					}
			    }
		    }
			$paginationCtrls .= ''.$pagenum.' &nbsp; ';													// Render the target page number, but without it being a link
			for($i = $pagenum+1; $i <= $last; $i++){													// Render clickable number links that should appear on the right of the target page number
				$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
				if($i >= $pagenum+4){
					break;
				}
			}
			if ($pagenum != $last) {																	// This does the same as above, only checking if we are on the last page, and then generating the "Next"
		        $next = $pagenum + 1;
		        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'"><span class="glyphicon glyphicon-forward"></a> ';
		    }
		}
		include ('view/form_people_table_header.html');
		while($row = mysqli_fetch_array($people, MYSQLI_ASSOC)){
			$found_user_id = $row['user_id'];
			$first_name = $row["First Name"];
			$last_name = $row["Last Name"];
			$publisher_type = $row["Publisher Type"];
			$servant_type = $row["Servant Type"];
			include ('view/form_people_table.html');
		}
		echo '</table></div>';																			// This table and div begin in 'view/form_people_table_header.html'
		include ('view/form_people_pagination.html');
	}
}
include ('include/footer.html');																		//Include the footer
?>