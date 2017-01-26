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

function getCurrentTermServiceEvents() {
	$classStartDate = db_currentClass('start');

	$sql = 'SELECT DISTINCT event_name, event_date '
				. 'FROM event, tracking '
				. 'WHERE eventtype_id = 1 AND event.event_id = tracking.event_id ' 
				. 'AND tracking.hours > 0 '
				. 'AND event_date > ' . " $classStartDate ";

  return db_select($sql, "getCurrentTermServiceEvents");
}

function show_CurrentTermServiceEvents() {
	$result = getCurrentTermServiceEvents();
	// each row contains:
	// event_name, event_date
	
	foreach ($result as $row) {
		echo "<tr>";
			echo "<td>";
				echo $row['event_name'];
			echo "</td>";
			echo "<td>";
				echo $row['event_date'];
			echo "</td>";
		echo "</tr>";
	}

}


show_filters();
?>

<div id="name-list-container">
 <h1>All Service Events From This Term</h1>
	<table id="name-list" class="table table-condensed table-bordered show-table">
		<tr>
			<th width="50%">Event Name</th>
			<th width="50%">Date</th>
		</tr>
		<?php
			show_CurrentTermServiceEvents();
		?>
	</table>
</div>

<!-- this script automatically adds data-th attributes to all <td> -->
<!-- allows for <th> elements to show up responsively/in mobile views -->
<script src="/js/event_show_responsive_th.js"></script>

<?php
show_footer();

?>
