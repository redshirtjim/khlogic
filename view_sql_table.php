<?php // - view_sql_table.php
//Admin page used to add, edit, and delete publishers.
session_start();
//Include the header:
include('include\header.html');

$db_host = 'localhost';
$db_user = 'jrroot';
$db_pwd = 'judg1256';

$database = 'khconnect';
$table = 'pubs';

if (!mysql_connect($db_host, $db_user, $db_pwd))
    die("Can't connect to database");

if (!mysql_select_db($database))
    die("Can't select database");

// sending query
$result = mysql_query("SELECT first_name, last_name, pub_type, email, phone_1, phone_2 FROM {$table}");
if (!$result) {
    die("Query to show fields from table failed");
}

$fields_num = mysql_num_fields($result);

print '<p>Table: ' . $table . '</p>';
print '<p><table><tr><td>one</td><td>two</td><td>three</td></tr><tr><td>one</td><td>two</td><td>three</td></tr></table>';
												/*print "<table border='0' width='900'>";
												//<tr>";
												// printing table headers
												//for($i=0; $i<$fields_num; $i++)
												//{
												  //  $field = mysql_fetch_field($result);
													//print "<td>{$field->name}</td>";
												//}
												//print "</tr>\n";
												// printing table rows
												*/

/*   //I can't figure out why this table want to print after the footer include.
// Printing the header like I want it.
print '<table><tr><td><u><b>First Name</b></u></td>
<td><u><b>Last Name</b></u></td>
<td><u><b>Type</b></u></td>
<td><u><b>E-mail</b></u></td>
<td><u><b>Phone 1</b></u></td>
<td><u><b>Phone 2</b></u></td></tr>';

while($row = mysql_fetch_row($result))
{
    print '<tr>';

    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable
    foreach($row as $cell)
        print "<td><p>$cell</p></td>";

    print "</tr>\n";
}
*/

//mysql_free_result($result);

// Close the connection.
Include('db_close.php');

//Include the footer:
include('include\footer.html');
?>