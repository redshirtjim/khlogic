<?php

require (MYSQL);

$query = "SELECT user_id, assign_type_id, at.assignment AS 'Assignment', CONCAT(u.first_name,' ',u.last_name) as 'Name', p.page AS Page
FROM assignments AS a
INNER JOIN assignment_type AS at
USING ( assign_type_id )
INNER JOIN users AS u
USING ( user_id )
INNER JOIN page AS p
USING ( page_id )
WHERE week_of = '2013-01-01' AND page_id = 1";

$r = mysqli_query ($dbc, $query) OR die("MySQL error: " . mysqli_error($dbc) . "<hr>\nQuery: $query");
//$row = mysqli_fetch_array($r);
while ($row = mysqli_fetch_array($r)) {

//if ($row['assign_type_id'] = '10') 
print '
<table>
		<tr>
		<td>' . $row['Assignment'] . '</td>
		<td>' . $row['Name'] . '</td>
		<td>' . $row['Page'] . '</td>
		</tr>
</table>'
;
}


print '
<table>
		<tr>
		<td><b>Congregation Bible Study</b></td>
		</tr>
		<tr>
		<td>Overseer: </td>
		<td>' . $row['Name'] . '</td>
		</tr>
		<tr>
		<td>Reader: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>Opening Prayer: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>Sound Panel: </td>
		<td>DATA</td>
		<td>Stage: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>Microphone: </td>
		<td>DATA</td>
		<td>Microphone: </td>
		<td>DATA</td>
		</tr>

		<tr>
		<td><b>Theocratic Ministry School</b></td>
		</tr>
		<tr>
		<td>Bible Highlights: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>No 1: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>No 2: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>No 2 Householder: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>No 3: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>No 3 Householder: </td>
		<td>DATA</td>
		</tr>

		<tr>
		<td><b>Service Meeting</b></td>
		</tr>
		<tr>
		<td>1st part: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>2nd part: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>3rd part: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>Concluding Pray: </td>
		<td>DATA</td>
		</tr>
		

		<tr>
		<td><b>Public Meeting</b></td>
		</tr>
		<tr>
		<td>Speaker: </td>
		<td>DATA</td>
		<td>Congregation: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>Chairman: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>Watchtower Reader: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>Sound Panel: </td>
		<td>DATA</td>
		<td>Stage: </td>
		<td>DATA</td>
		</tr>
		<tr>
		<td>Microphone: </td>
		<td>DATA</td>
		<td>Microphone: </td>
		<td>DATA</td>
		</tr>

</table>
';
?>		