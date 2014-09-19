<?php
$select_detail_start = '<select name="start_slip" id="start_slip">';
$select_detail_end = '<select name="end_slip" id="end_slip">';
$select_title_start = '';
$select_title_end = '';
echo '<div class="clearfix visible-xs-block" style="float:right;">';
	echo '<form class="form-inline" role="form" name="make_slips" action="tms_assign_slips.php?start_slip=' . $_GET['start_slip'] . '&end_slip=' . $_GET['end_slip'] . '" method="get" target="_blank">';
		echo '<div class="form-group col-md-12">';
			echo '<label for="slips">Start slips at...</label>';
			week_of($select_detail_start, $select_title_start);
			echo '<input class="btn btn-primary" type="submit" value="Generate Slips">';
		echo '</div>';
	echo '</form>';
echo '</div>';
?>