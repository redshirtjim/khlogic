<?php # config.inc.php
/* Jim Rush, 10/22/2012
KHLogic is an application designed to eliminate or reduce scheduling conflicts as multiple schedulers simultaneously give assignments and responsibilities to people in the same resource pool.
It is designed to coordinate all the activities involved in the weekly meetings at a Kingdom Hall. It is to be used by individuals responsible for scheduling and assigning responsibilities for the Public Meeting, Watchtower Study, Congregation Bible Study, Theocratic Ministry School, and Service Meeting, as well as meeting attendants, stage attendant, sound panel attendant, microphone attendants, facility cleaning, and grounds keeping.
The goal is to eliminate or reduce the potential for individuals to be scheduled for conflicting assignments and responsibilities. 
This script:
 * - define constants and settings
 * - defines useful functions ( in another inc.php)  */
// ********************************** //
// *********** SETTINGS ************* //
// ********************************** //
// Flag variable for site status:
define('LIVE', TRUE);
// Admin contact address:
$contact_email = 'jimrush72@gmail.com'; 
define('EMAIL', 'jimrush72@gmail.com');
// Site URL (base for all redirections):
define('BASE_URL', 'http://khlogic.org/');
// Location of the MySQL connection script:
define('MYSQL', 'db_conn_sel.php');
define('CLSMYSQL', 'db_close.php');
// Set the database access information as constants:
define('DB_USER', 'dbo437696394');
define('DB_PASSWORD', 'Judges@1256');
define('DB_HOST', 'db437696394.db.1and1.com');
define('DB_NAME', 'db437696394');
// Adjust the time zone for PHP 5.1 and greater:
date_default_timezone_set ('US/Central');
// Default Watchtower Overseer:
define('DEF_WT_OVER', 'Richard Zentz');
define('DEF_WT_OVER_ID', '3');
// Default Congregation Name
define ('DEF_CONG', 'South Lee\'s Summit');
// Number of schools (1, 2, or 3):
define('NUMBER_SCHOOLS', '1');
// ********************************** //
// ******* END SETTINGS ************* //
// ********************************** //