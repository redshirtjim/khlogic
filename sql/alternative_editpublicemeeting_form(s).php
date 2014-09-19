			<table>
		<form action="<?php print $page; ?>" method="post">
				<tr>
				<td>Public Speaker:</td>
				<td>
				<select name="pspeaker" onchange="this.form.submit()">
				<?php
				if ($num_row_speaker = 1) {
					print '<option value="'.$row_speaker['user_id'].'" selected>'.$row_speaker['Name'].'</option>';
					while ($row1 = mysqli_fetch_array($r1)) {
						print '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
					}
				} else {
					while ($row1 = mysqli_fetch_array($r1)) {
						print '<option value="'.$row1['user_id'].'">'.$row1['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
		</form>
				
		<form action="<?php print $page; ?>" method="post">
	
				<tr>
				<td>Chairman:</td>
				<td>
				<select name="chairman" onchange="this.form.submit()">
				<?php
				if ($num_row_chairman = 1) {
					print '<option value="'.$row_chairman['user_id'].'" selected>'.$row_chairman['Name'].'</option>';
					while ($row2 = mysqli_fetch_array($r2)) {
						print '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
					}
				} else {
					while ($row2 = mysqli_fetch_array($r2)) {
						print '<option value="'.$row2['user_id'].'">'.$row2['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
		</form>
				
		<form action="<?php print $page; ?>" method="post">
	
				<tr>
				<td>Watchtower Overseer:</td>
				<td>
				<select name="wtoverseer" onchange="this.form.submit()">
				<?php
				print '<option value="'.DEF_WT_OVER_ID.'" selected>'.DEF_WT_OVER.'</option>';
				if ($num_row_wtoverseer = 1) {
//					print '<option value="'.$row_wtoverseer['user_id'].'" selected>'.$row_wtoverseer['Name'].'</option>';
					while ($row3 = mysqli_fetch_array($r3)) {
						print '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
					}
				} else {
					while ($row3 = mysqli_fetch_array($r3)) {
						print '<option value="'.$row3['user_id'].'">'.$row3['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
		</form>

		<form action="<?php print $page; ?>" method="post">
	
				<tr>
				<td>Watchtower Reader:</td>
				<td>
				<select name="wtreader" onchange="this.form.submit()">
				<?php
				if ($num_row_wtreader = 1) {
					print '<option value="'.$row_wtreader['user_id'].'" selected>'.$row_wtreader['Name'].'</option>';
					while ($row4 = mysqli_fetch_array($r4)) {
						print '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
					}
				} else {
					while ($row4 = mysqli_fetch_array($r4)) {
						print '<option value="'.$row4['user_id'].'">'.$row4['Name'].'</option>';
					}
				}
				?>
				</select>
				</td>
				</tr>
		</form>
			</table>