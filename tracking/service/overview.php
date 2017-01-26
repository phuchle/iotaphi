<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/database.inc.php';
include_once '../sql.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	
if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
}
	
if(isset($_SESSION['class'])) {
	$class = $_SESSION['class'];
}

get_header();

if($class != 'admin'){
	show_note('You must be excomm to view this page!');
}

/////// begin phuc

// returns: event_name, date, shift_start, shift_end, members_per_shift, hours_per_shift
function getShiftDurations() {
	$classStartDate = db_currentClass('start');
	$sql = 'SELECT '
					  . "event.event_name AS 'event_name', "
					  . "DATE(EVENT.event_date) AS date, "
					  . "shift.shift_start, "
					  . "shift.shift_end, "
					  . "COUNT(signup.user_id) as 'members_per_shift', "
					  . "TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end) AS 'hours_per_shift' "
					. "FROM shift, tracking, event, signup "
					. "WHERE "
					  . "tracking.hours > 0  "
					  . "AND shift.event_id = tracking.event_id  "
					  . "AND event.event_id = shift.event_id  "
					  . "AND (TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end) > 0)  "
					  . "AND signup.shift_id = shift.shift_id "
					  . "AND signup.user_id = tracking.user_id "
					  . 'AND event.event_date > ' . "$classStartDate "   
					. "GROUP BY shift.shift_id ";

  return db_select($sql);
}


function show_ShiftDurations() {
	$result = getShiftDurations();
// each row contains:
// event_name, date, shift_start, shift_end, members_per_shift, hours_per_shift
	
	foreach ($result as $row) {
		echo "<tr>";
			echo "<td>";
				echo $row['event_name'];
			echo "</td>";
			echo "<td>";
				echo $row['date'];
			echo "</td>";
			echo "<td>";
				echo $row['shift_start'];
			echo "</td>";
			echo "<td>";
				echo $row['shift_end'];
			echo "</td>";
			echo "<td>";
				echo $row['members_per_shift'];
			echo "</td>";
			echo "<td>";
				echo $row['hours_per_shift'];
			echo "</td>";
			echo "<td>";
				echo ($row['members_per_shift'] * $row['hours_per_shift']);
			echo "</td>";

		echo "</tr>";
	}
}

/////// end phuc

show_filters();
?>

<div id="name-list-container">
 <h1>Service per Shift and Brothers per Shift</h1>
	<table id="name-list" class="table table-condensed table-bordered show-table">
		<tr>
			<th width="30%">Event Name</th>
			<th width="10%">Date</th>
			<th width="10%">Shift Start</th>
			<th width="10%">Shift End</th>
			<th width="13%">Brothers per shift</th>
			<th width="12%">Hours per shift</th>
			<th width="15%">Total Hours (brothers x hours per shift)</th>
		</tr>
		<?php
			show_ShiftDurations();
		?>
	</table>
</div>

<!-- this script automatically adds data-th attributes to all <td> -->
<!-- allows for <th> elements to show up responsively/in mobile views -->
<script src="/js/event_show_responsive_th.js"></script>

<?php
show_footer();

?>
