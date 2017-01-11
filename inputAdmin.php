<?php
include_once 'include/template.inc.php'; 

// permissions?
if($_SESSION['class']!="admin")
	show_note('You must be an administrator to access this page.');

// for readability (not a threat since only POST is used anyway)
extract($_POST);

if($action == 'eventCreate' or $action == 'eventUpdate')
{
	if($hot!=1) { $hot=0; }

	if(isset($name, $date, $time, $type, $ic, $fund, $fellowboat, $location, $mileage, $description, $custom1, $custom2, $custom3, $custom4, $custom5, $hot))
	{
		include_once 'include/event.inc.php';

		foreach ($date as $index => $date) 
		{
			// format inputs for database
			$timestamp = strtotime("$date $time");
			$hour = date('H',strtotime($duration));
			$minutes = date('i',strtotime($duration));
			$endtimestamp = strtotime("+$hour hours $minutes minutes", $timestamp);
			
			if($action=='eventUpdate') {
				event_update($name,$timestamp,$endtimestamp,$type,$ic, $fund, $fellowboat, $location, $address, $map,$mileage,$description,$event_id,$contact, $custom1, $custom2, $custom3, $custom4, $custom5, $hot);
			}
			elseif($action=='eventCreate') {
				$event_id = event_add($name,$timestamp,$endtimestamp,$type,$ic, $fund, $fellowboat, $location, $address, $map, $mileage,$description,$contact, $custom1, $custom2, $custom3, $custom4, $custom5, $hot);
				
				include_once 'include/signup.inc.php';

				if ($capacity > 0) {
					$start_time = date('H:i:00', strtotime("$time"));
					$end_time = date('H:i:00', strtotime("+$hour hours $minutes minutes", strtotime("$time")));

					shift_add($event_id, $start_time, $end_time, $capacity, '');
				}
				// If fellowboat, automatically create shift with cap of 10 people
				elseif ($fellowboat == 1) {
					// format inputs for database
					$start_time = date('H:i:00', strtotime("$time"));
					$end_time = date('H:i:00', strtotime("+$hour hours $minutes minutes", strtotime("$time")));

					shift_add($event_id, $start_time, $end_time, 10, '');
				}
				// If created event type doesn't have multiple shifts, automatically create a shift
				// fellowboats excluded
				elseif (!event_multipleShiftsNumeric($type)) {		
					shift_add($event_id,'00:00:00','00:00:00',0,'');
				}
			}
		}		
	}
	else {
				show_note('Error updating or creating event: one of the required fields was left blank.');
	}
}

elseif($action == 'eventDelete')
{
	include_once 'include/event.inc.php';
	event_delete($event_id);
}
elseif($action == 'shiftCreate' or $action == 'shiftUpdate')
{
	include_once 'include/signup.inc.php';
	// format inputs for database
	$stamp1 = date('H:i:00',strtotime($start));
	$stamp2 = date('H:i:00',strtotime($end));
	
	if($action=='shiftUpdate')
	{
		shift_update($shift,$event,$stamp1,$stamp2,$capacity,$name);
	}
	elseif($action=='shiftCreate')
	{
		shift_add($event,$stamp1,$stamp2,$capacity,$name);
	}
}
elseif($action == 'shiftDelete')
{
	include_once 'include/signup.inc.php';
	shift_delete($shift);
}
elseif($action=='signup')
{
	include_once 'include/signup.inc.php';
	// if any shifts and people are selected
	if(count($shift) && count($user))
		signup_add($shift, $user, isset($chair)?1:0,isset($driving)?1:0,isset($camera)?1:0,isset($ride)?1:0);
	else{}
}
elseif($action=='signupdate')
{
	include_once 'include/signup.inc.php';
	signup_update($shift, $user, isset($chair)?1:0,isset($driving)?1:0,isset($camera)?1:0, isset($ride)?1:0);
}
elseif($action=='signupdateorder')
{
	include_once 'include/signup.inc.php';
	signup_updateOrder($shift, $user, $order);
}
elseif($action=='unsignup')
{
	include_once 'include/signup.inc.php';
	signup_delete($shift,(int)$user);
}
header("Location: " . $redirect);
?>
