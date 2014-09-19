<?php	

		$row_wtreader_assign = mysqli_fetch_array ($r_wtreader_assign, MYSQLI_ASSOC);

$assign_id = $row_wtreader_assign['assign_id'];
			$week_of = $row_wtreader_assign['week_of'];
			$user_id = $row_wtreader_assign['user_id'];
			$assign_type_id = $row_wtreader_assign['assign_type_id'];
			$page_id = $row_wtreader_assign['page_id'];
			
			if ($week_of = $monday AND $page_id = 1) {
				print "Attention: '$user_id' has already been assigned to '$assign_type_id'";
			}	
	