<?php
/* config.inc.php
Jim Rush, 10/22/2012
*/
// ************ FUNCTIONS ************ //
// ****************************************** //
// function week_of()
function week_of ($select_detail, $select_title) {
	
	$page = $_SERVER['REQUEST_URI'];
	$last_monday = date('Y-m-d', strtotime('last Monday'));
	$today_monday = date('Y-m-d', strtotime('Today'));
	$first_monday = date('Y-m-d', strtotime('first Monday'));
	$second_monday = date('Y-m-d', strtotime('second Monday'));
	$third_monday = date('Y-m-d', strtotime('third Monday'));
	$fourth_monday = date('Y-m-d', strtotime('fourth Monday'));
	$fifth_monday = date('Y-m-d', strtotime('+7 days fourth Monday'));
	$sixth_monday = date('Y-m-d', strtotime('+14 days fourth Monday'));
	$seventh_monday = date('Y-m-d', strtotime('+21 days fourth Monday'));
	$eight_monday = date('Y-m-d', strtotime('+28 days fourth Monday'));
	$ninth_monday = date('Y-m-d', strtotime('+35 days fourth Monday'));
	$tenth_monday = date('Y-m-d', strtotime('+42 days fourth Monday'));
	$elevnth_monday = date('Y-m-d', strtotime('+49 days fourth Monday'));
	$twelth_monday = date('Y-m-d', strtotime('+56 days fourth Monday'));
	$thirteen_monday = date('Y-m-d', strtotime('+63 days fourth Monday'));
	$weekday = date('N');
	
	// Make the week of pull-down menu:
	echo '<div class="dropdown">';
	echo '<a data-toggle="dropdown" href="#"><button class="btn btn-default dropdown-toggle main-weekof" type="button" id="dropdownMenu1" data-toggle="dropdown">';
	echo '<b>' . $select_title . '</b>';
	echo "<form action='$page' method='post' class='monday'>";
	echo $select_detail; //This variable helps define the behavior of the select option. It is passed in the function call.
	echo '<option value=""> </option>';
	if ($weekday == 1) {
		echo "<option value='$today_monday'>"; echo date('F j, Y', strtotime('Today')); echo '</option>';
	} else {
		echo "<option value='$last_monday'>"; echo date('F j, Y', strtotime('last Monday')); echo '</option>';
	}
	echo "<option value='$first_monday'>"; echo date('F j, Y', strtotime('first Monday')); echo '</option></li>';
	echo "<option value='$second_monday'>"; echo date('F j, Y', strtotime('second Monday')); echo '</option>';
	echo "<option value='$third_monday'>"; echo date('F j, Y', strtotime('third Monday')); echo '</option>';
	echo "<option value='$fourth_monday'>"; echo date('F j, Y', strtotime('fourth Monday')); echo '</option>';
	echo "<option value='$fifth_monday'>"; echo date('F j, Y', strtotime('+7 days fourth Monday')); echo '</option>';
	echo "<option value='$sixth_monday'>"; echo date('F j, Y', strtotime('+14 days fourth Monday')); echo '</option>';
	echo "<option value='$seventh_monday'>"; echo date('F j, Y', strtotime('+21 days fourth Monday')); echo '</option>';
	echo "<option value='$eight_monday'>"; echo date('F j, Y', strtotime('+28 days fourth Monday')); echo '</option>';
	echo "<option value='$ninth_monday'>"; echo date('F j, Y', strtotime('+35 days fourth Monday')); echo '</option>';
	echo "<option value='$tenth_monday'>"; echo date('F j, Y', strtotime('+42 days fourth Monday')); echo '</option>';
	echo "<option value='$elevnth_monday'>"; echo date('F j, Y', strtotime('+49 days fourth Monday')); echo '</option>';
	echo "<option value='$twelth_monday'>"; echo date('F j, Y', strtotime('+56 days fourth Monday')); echo '</option>';
	echo "<option value='$thirteen_monday'>"; echo date('F j, Y', strtotime('+63 days fourth Monday')); echo '</option>';
	echo '</select>';
	echo '</form>';
	echo '</button></a>';
	echo '</div>';
} // End of week-of function.
// function get_monday_date()
function get_monday_date($method, $get_monday, $post_monday) {
	require ('include/config.inc.php');
	$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];	
	// GET the date for Monday for the PDF view:	
	if ($method == 'GET') {
		$monday = $get_monday;
	}	
	// Determine the date for Monday for initial view:
	if ($host == 'khlogic.org/index.php') {
		$weekday = date('N');
		if ($weekday == 1) {
			$monday = date('Y-m-d', strtotime('Today'));
		} else {
			$monday = date('Y-m-d', strtotime('last Monday'));
		}
	}
	//POST the date for Monday when a date is selected in the drop down:
	if ($method == 'POST') {
		$monday = $post_monday;
	}
	
return $monday;
}
// ***************************************************** //
// ************ week_nav() function ******************** //
// ***************************************************** //

function week_nav ($nav_href, $monday) {
	$nextw = date('Y-m-d', strtotime('+7 days', strtotime($monday)));
	$prevw = date('Y-m-d', strtotime('-7 days', strtotime($monday)));
	$weekday = date('N');
	if ($weekday == 1) {
		$currw = date('Y-m-d', strtotime('Today'));
	} else {
			 $currw = date('Y-m-d', strtotime('last Monday'));
		 }
	echo '
	<a href="' . $nav_href . $prevw . '"><span class="glyphicon glyphicon-backward"></a>';
	if ($currw != $monday) {
		echo '<a href="' . $nav_href . $currw . '">     This Week     </a>';
	}
	echo '<a href="' . $nav_href . $nextw . '"><span class="glyphicon glyphicon-forward"></a>';
}
// ***************************************************** //
// ********** END week_nav() function ****************** //
// ***************************************************** //

