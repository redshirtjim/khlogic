<?php //Week_of.php, this file holds the date selector function.
echo '<div id="weekof" class="">';
$select_detail = '<select name="monday" id="monday" onchange="this.form.submit()">';
$select_title = 'Week of Monday ... ';
week_of($select_detail, $select_title); //Function in include/config.inc.php
echo '</div>';
?>