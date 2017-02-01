<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/database.inc.php';
include_once '../sql.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();

if($class != 'admin')
	show_note('You must be excomm to view this page!');

/////// begin phuc

function getShiftDurations($shift_id, $event_id) {
	$date = NOW;
	$sql = 'SELECT '
					  . "EVENT.event_name AS 'Event Name', "
					  . "DATE(EVENT.event_date) AS Date, "
					  . "shift.shift_start, "
					  . "shift.shift_end, "
					  . "COUNT(signup.user_id) as 'Members per shift', "
					  . "TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end) AS 'Hours per shift' "
					. "FROM shift, tracking, event, signup "
					. "WHERE "
					  . "tracking.hours > 0  "
					  . "AND shift.event_id = tracking.event_id  "
					  . "AND EVENT.event_id = shift.event_id  "
					  . "AND (TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end) > 0)  "
					  . "AND signup.shift_id = shift.shift_id "
					  . "AND signup.user_id = tracking.user_id "
					  . 'AND event.event_date > ' . db_currentClass('start');
					. "GROUP BY shift.shift_id "
					. 'ORDER BY DATE DESC';

  return db_select1($sql, "getShiftDurations");
}



function getCurrentTermServiceEvents(){
	$sql = 'SELECT DISTINCT event_name, event_date '
				. 'FROM event, tracking '
				. 'WHERE eventtype_id = 1 AND event.event_id = tracking.event_id ' 
				. 'AND tracking.hours > 0'
				. 'AND event_date > ' . db_currentClass('start');

  return db_select1($sql, "getCurrentTermServiceEvents");
}

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "website_data_" . date('Ymd') . ".xls";
  	$sql = 'SELECT '
					  . "EVENT.event_name AS 'Event Name', "
					  . "DATE(EVENT.event_date) AS Date, "
					  . "shift.shift_start, "
					  . "shift.shift_end, "
					  . "COUNT(signup.user_id) as 'Members per shift', "
					  . "TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end) AS 'Hours per shift' "
					. "FROM shift, tracking, event, signup "
					. "WHERE "
					  . "tracking.hours > 0  "
					  . "AND shift.event_id = tracking.event_id  "
					  . "AND EVENT.event_id = shift.event_id  "
					  . "AND (TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end) > 0)  "
					  . "AND signup.shift_id = shift.shift_id "
					  . "AND signup.user_id = tracking.user_id "
					  . 'AND event.event_date > ' . db_currentClass('start');
					. "GROUP BY shift.shift_id "
					. 'ORDER BY DATE DESC';

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $result = mysql_query($sql);
  while(false !== ($row = mysqli_fetch_assoc($result))) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;


/////// end phuc
function getTotal($user)
{
	$date = NOW; // now
	 $sql = 'SELECT sum( hours ) AS h, sum( projects ) AS p, sum( chairs ) AS c'
        . ' FROM event NATURAL JOIN tracking'
        . " WHERE eventtype_id = 1 AND user_id = '$user' "
        . " AND event.event_date > " . db_currentClass('start');

	$total = db_select1($sql, "getTracked()");

	$sql = 'SELECT count( * ) AS drove'
        . ' FROM event NATURAL JOIN tracking WHERE passengers > 0'
        . " AND eventtype_id = '1' AND user_id = '$user' "
        . " AND event.event_date > " . db_currentClass('start');

	$temp = db_select1($sql, "getTracked()");
	$total['drove'] = $temp['drove'];

	$total['h'] += 0;
	$total['p'] += 0;
	$total['c'] += 0;
	
	return $total;

}

function show_eventsTrack($name, $user)
{
	$total = array();
	?>
		<?php 
			$total = getTotal($user);
			if( $total['h'] > 0 || $total['p'] > 0){
				echo "<tr id=\"r$user\">";
				$fourc_totals = getCTotal($user, db_currentClass('class_id'));
				echo "<td><a href=\"/tracking/service/user.php?user=$user\">$name</a></td>";
				echo "<td>{$total['h']}</td>";
				echo "<td>{$total['p']}</td>";
				echo "<td>{$total['c']}</td>";
				echo "<td>{$total['drove']}</td>";
				
				$c[0] = $c[1] = $c[2] = $c[3] = 0;
				foreach($fourc_totals as $fourc_total)
				{
					$c[$fourc_total['fourc_c']] = $fourc_total['C'];
				}
				
				echo "<td class=\"small fourc0\">{$c[0]}</td>";
				echo "<td class=\"small fourc1\">{$c[1]}</td>";
				echo "<td class=\"small fourc2\">{$c[2]}</td>";
				echo "<td class=\"small fourc3\">{$c[3]}</td>";
				echo "</tr>";
			}
		?>
	<?php 
}

$everyone = user_getAll(); 

show_filters();
?>

<div id="name-list-container">
 <h1>Overview of Brothers' Service for </h1>
	<table id="name-list" class="table table-condensed table-bordered show-table">
		<tr>
			<th width="50%">Name  </th>
			<th width="10%">Hours </th>
			<th width="10%">Projects</th>
			<th width="10%">Chair </th>
			<th width="20%">Times Driving</th>
			<th width="10%" colspan="4">C's</th>
		</tr>
		<?php
		foreach($everyone as $one)
			show_eventsTrack($one['name'], $one['id']);
		?>
	</table>
</div>

<!-- this script automatically adds data-th attributes to all <td> -->
<!-- allows for <th> elements to show up responsively/in mobile views -->
<script src="/js/event_show_responsive_th.js"></script>

<?php
show_footer();

?>
