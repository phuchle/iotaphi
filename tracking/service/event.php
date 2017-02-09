<?php
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once '../sql.php';

include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');


if(isset($_GET['event']))
	$event = $_GET['event'];

if(isset($_SESSION['id']))
	$id = $_SESSION['id'];

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

echo '<script type="text/javascript" src="/js/calculate_tracking_hours.js"></script>';

get_header();

$temp=user_get($id, 'f');
$temp=$temp['name'];

if ( !( ($temp == 'service' || $temp == 'admin') && $class=='admin') )
	show_note('You must be logged in as service to access this page.');

function show_usersTrack($users, $name, $event)
{
	// returns [$start_date, $end_date]
	$event_begin_and_end_dates = extract(event_get_date_time($event));
	?>

	<h3 class="heading" colspan="6"><?php echo $name ?></h3>

	<p>Start Time: <?php echo date('g:i a',$start_date); ?></p>
	<p>End Time: <?php echo date('g:i a',$end_date); ?></p>
	<p>
		Reported Hours - Tracked Hours = Tracked Hours
	</p>
	<p>
		<strong>
			Note: nothing is saved until the Submit Tracking button is pressed.
		</strong>
	</p>

	<p>
		<strong>
			NOTE: Reported Hours (from the chair) - Positive Hours (SVPs enter) =
			Total Hours
		</strong>
	</p>
	<table id="name-list" class="table table-condensed table-bordered show-table">
	<tr>
		<th width="120">Name</th>
		<th width="50">Reported Hours </th>
		<th width="50">Positive Hours</th>
		<th width="50">Tracked Hours</th>
		<th width="40">Project</th>
		<th width="40">Chair </th>
		 <!--<th width="120">Driving<br>People / Miles</th> //temporary solution to the tracking problem// -->
		<th width="40">Chair Comments </th>
	</tr>

	<?php

	foreach($users as $user){
		if(isset($user['h']))
		{
			$class = 'small';
			$checked = 'checked';
		}
		else
		{
			$class = 'small waitlist';
			$checked = '';
		}

		?><tr id="r<?php echo $user['user_id'] ?>"><?php
		$all_hour_fields_set = isset($user['h']) && isset($user['service_hours']);

		echo "<td class=\"$class\">";
       echo "<input name=\"user[]\" type=\"checkbox\" $checked value=\"{$user['user_id']}\" "
         . "onclick='javascript:document.getElementById(\"h{$user['user_id']}\").disabled = !this.checked; "
         . "clearDisabledInput(\"h{$user['user_id']}\", \"ph{$user['user_id']}\");'/>";

        echo "<span title=\"{$user['class_nick']} Class\">{$user['name']}</span></td>";

				echo "<td class=\"$class\">"; // reported hours

				echo "<input class='hours-input' id=reported-hours{$user['user_id']} type='text' size='5' value=\"{$user['service_hours']}\">";
				echo " hrs </td>";

		echo "<td class=\"$class\">"; // positive hours

			if (isset($user['h']) && isset($user['service_hours']) ) {
				$positive_hour_input = $user['h'] - $user['service_hours'];
			}
			else {
				$positive_hour_input = "";
			}

			$reported_hours_JS = "'reported-hours{$user['user_id']}'";
			$tracked_totals_for_JS = "'h{$user['user_id']}'";

		echo "<input class='hours-input' id=ph{$user['user_id']} name='ph[{$user['user_id']}]' "
	   . "type='text' size='5' maxlength='6' value='$positive_hour_input' "
     . "onkeyup=\"calculateServiceHours(this.value, $reported_hours_JS, $tracked_totals_for_JS);\"/>";
		echo " hrs </td>";

    echo "<td class=\"$class\">"; // tracked hours
	    $disabled = $checked ? "" : "disabled";

	    echo "<input class='hours-input' id=h{$user['user_id']} name='h[{$user['user_id']}]' "
	       . "type='text' size='5' maxlength='6' value='{$user['h']}' "
	       . " $disabled /> hrs";
		echo " </td>";


		echo "<td class=\"$class\">";
		forms_checkbox("p[{$user['user_id']}]", 1, $user['p']);

		echo "</td>";
		echo "<td class=\"$class\">";

		//$user_check_for_chair returns true if user is chair, else false
		//looks in the signup table for chair
		$user_check_for_chair = user_isChair($user['user_id'], $event);
		forms_checkbox("c[{$user['user_id']}]", 1, $user_check_for_chair);

		echo "</td><td class=\"$class\" align=\"center\">";
		forms_text(30,"details[{$user['user_id']}]", $user['details']);

	   //  forms_decimal("mi[{$user['user_id']}]", $user['mi']);
	   // 	echo " mi </td><td class=\"$class\">";

		echo '</td>';
		echo '</tr>';
	} ?>
	</table>

	<!-- this script automatically adds data-th attributes to all <td> -->
	<!-- allows for <th> elements to show up responsively/in mobile views -->
	<script src="/js/event_show_responsive_th.js"></script>

	<?php
}

if(!isset($event)) // show list of events to track
{
	// get service events
	$list = array_reverse(getEvents(1, true)); // events are listed new to old
	?>
	<form name="selecttracking" method="GET" action="/tracking/service/event.php">
	<select name="event" size="1">
			<?php foreach($list as $line):
				$text = date("m/d/y", $line['date']) . ' ' . $line['event_name'];
				echo "<option ";
				echo "value=\"{$line['event_id']}\">$text</option>";
			endforeach; ?>
	</select>
	<?php forms_submit('Track') ?>
	</form>
	<?php
}
else // shows tracking page for the specific event
{
	show_filters();

	$name = event_get($event);  //$event is an id

	$users = getTrackedEvent($event); //the behavior of this function has changed, it now returns an array of arrays, containing an array for each non-hidden user, with each sub-array containing tracking, trackingbyuser, and chair info for that user and the input event
	?>
	<form name="settracking" method="POST" action="/tracking/input.php">
	<?php forms_hiddenInput("settracking","/tracking/service/event.php?event=$event");
	forms_hidden('event', $event);
	show_usersTrack($users, date('m/d/y', $name['date']) . ' ' . $name['name'], $event);
	forms_submit('Set Tracking');
	?></form>
	<?php
	$submits = getTrackingTime($event); // reads time from trackingtime
	echo '<table cellspacing="1"><tr><th>Chair Modification History</th></tr>';
	foreach($submits as $submit)
	{
		$date = date('F jS, Y \a\t g:ia', $submit['date']);
		echo "<tr><td>Modified on <strong>$date</strong> by <strong>{$submit['name']}</strong>.</td></tr>";
	}
	echo '</table>';
}

foreach($list as $user){
	echo $user['name'];
}
show_footer(); ?>
