<?php
// Checks for chairless events happening 3 days and randomly assigns someone signed up to be chair.

// Add include path, needed in cronjobs because it uses a different php.ini which doesn't have our include directory
$path = '/home/iotaphi/iotaphi.org/include';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

include_once 'database.inc.php';
db_open();

// Get all chairless shifts on the 3rd day from now
$query = ' SELECT event_name, signup.shift_id, shift.event_id '
         . ' FROM event, shift, signup '
         . ' WHERE event.event_id = shift.event_id AND '
         . ' shift.shift_id = signup.shift_id AND '
         . ' event_date > DATE_ADD(CURRENT_DATE(), INTERVAL 3 DAY) AND '
         . ' event_date < DATE_ADD(CURRENT_DATE(), INTERVAL 4 DAY) '
		 . ' GROUP BY signup.shift_id '
		 . ' HAVING SUM(signup_chair) < 1 ';

$result = db_select($query);

foreach ($result as $shift) {

	// For each chairless shift, get all signups
	$query = ' SELECT user_name, user_email, user.user_id '
	         . ' FROM event, shift, signup, user '
	         . ' WHERE event.event_id = shift.event_id AND '
	         . ' shift.shift_id = signup.shift_id AND '
			 . ' user.user_id = signup.user_id AND '
			 . ' shift.shift_id = '.$shift['shift_id'];
	
	$result = db_select($query);
	
	// Randomly select someone signed up to become chair
	$rand_key = array_rand($result);
	$newchair = $result[$rand_key];
	
	// Make them chair
	$query = " UPDATE signup SET signup_chair = 1 "
			 . " WHERE user_id = {$newchair['user_id']} AND "
			 . " shift_id = " . $shift['shift_id']
			 . " LIMIT 1";
			 
	mysql_query($query) or die();
	
	// Email them to let them know
	$name = $newchair['user_name'];
	$email = $newchair['user_email'];
	$event = $shift['event_name'];
	$subject = 'You\'re now chairing a service project!';
    $message = "Congratulations $name,\n\n"
             . "You've been randomly selected to chair an event that is happening in 3 days!\n"
             . "Please make the appropriate arrangements.\n"
             . "The event you're chairing is: <a href=\"http://www.iotaphi.org/event/show.php?id=$event_id.\">$event</a><br /><br />"
             . "Sincerely,\nThe Iotaphi Robot\n";
    $headers  = 'From: The IotaPhi Robot <admin@iotaphi.org>' . "\r\n";
    $headers .= 'Cc: service@iotaphi.org' . "\r\n";

    mail($email, $subject, $message, $headers);
	
	echo "Made $name chair of $event.\n";
}
?>