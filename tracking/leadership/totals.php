<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();

if($class != 'admin')
	show_note('You must be excomm to view this page!');

function getTotal($user)
{
	$date = NOW; // now
	 $sql = 'SELECT sum( projects ) AS events, sum( chairs ) AS c'
        . ' FROM event NATURAL JOIN tracking'
        . " WHERE eventtype_id = '7' AND user_id = '$user' "
        . " AND event.event_date > " . db_currentClass('start');

	$total = db_select1($sql, "getTracked()");
	
	$sql = 'SELECT count( * ) AS drove'
        . ' FROM event NATURAL JOIN tracking WHERE passengers > 0'
        . " AND eventtype_id = '7' AND user_id = '$user' "
        . " AND event.event_date > " . db_currentClass('start');

	$temp = db_select1($sql, "getTracked()");
	$total['drove'] = $temp['drove'];
	
	$total['events'] += 0;
	$total['c'] += 0;
	
	return $total;

}

function show_eventsTrack($name, $user)
{
	$total = array();
	?>
		<?php 
			$total = getTotal($user);
			if($total['events'] > 0){
				echo "<tr id=\"r<?php echo $user ?>\">";
				echo "<td><a href=\"/tracking/leadership/user.php?user=$user\">$name</a></td>";
				echo "<td>{$total['events']}</td>";
				echo "<td>{$total['c']}</td>";
				echo "<td>{$total['drove']}</td>";
				echo "</tr>";
			}
		?>
	<?php 
}

$everyone = user_getAll(); 

show_filter();
?>

<table id="usertable" class="table table-condensed table-bordered show-table">
	<tr>
		<th>Name  </th>
		<th>Credit</th>
		<th>Chair </th>
		<th>Times Driving</th>
	</tr>
	<?php
	foreach($everyone as $one)
		show_eventsTrack($one['name'], $one['id']);
	?>
</table>

<!-- this script automatically adds data-th attributes to all <td> -->
<!-- allows for <th> elements to show up responsively/in mobile views -->
<script src="/js/event_show_responsive_th.js"></script>

<?php
show_footer();
?>
