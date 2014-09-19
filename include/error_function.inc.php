<?php # config.inc.php
/*
Jim Rush, 10/22/2012
KHLogic is an application designed to eliminate or reduce scheduling conflicts as multiple schedulers simultaneously give assignments and responsibilities to people in the same resource pool.

It is designed to coordinate all the activities involved in the weekly meetings at a Kingdom Hall. It is to be used by individuals responsible for scheduling and assigning responsibilities for the Public Meeting, Watchtower Study, Congregation Bible Study, Theocratic Ministry School, and Service Meeting, as well as meeting attendants, stage attendant, sound panel attendant, microphone attendants, facility cleaning, and grounds keeping.

The goal is to eliminate or reduce the potential for individuals to be scheduled for conflicting assignments and responsibilities.
*/
/* This script:
 * 
 * - dictates how errors are handled
 * -
 */

// ****************************************** //
// ************ ERROR MANAGEMENT ************ //

// Create the error handler:
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

	// Build the error message:
	$message = "An error occurred in script '$e_file' on line $e_line: $e_message\n";
	
	// Add the date and time:
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n";
	
	if (!LIVE) { // Development (print the error).

		// Show the error message:
		echo '<div class="error">' . nl2br($message);
	
		// Add the variables and a backtrace:
		echo '<pre>' . print_r ($e_vars, 1) . "\n";
		debug_print_backtrace();
		echo '</pre></div>';
		
	} else { // Don't show the error:

		// Send an email to the admin:
		$body = $message . "\n" . print_r ($e_vars, 1);
		mail(EMAIL, 'Site Error!', $body, 'From: email@example.com');
	
		// Only print an error message if the error isn't a notice:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div><br />';
		}
	} // End of !LIVE IF.

} // End of my_error_handler() definition.

// Use my error handler:
set_error_handler ('my_error_handler');


// ************ END ERROR MANAGEMENT ************ //
// ****************************************** //