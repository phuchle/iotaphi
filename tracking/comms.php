<?php 

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once 'sql.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';

include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header();

if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

$temp=user_get($id, 'f');
$temp=$temp['name'];

if ( !($class=='admin') ) {
	show_note('You must be logged in as ExComm to access this page.');
}

show_filters();
$everyone = getCommTracking();

?>
<h3>Comm & Due Credit</h3>
<form action="/tracking/input.php" method="POST">
<?php forms_hiddenInput('setcommtracking', '/tracking/comms.php') ?>
<div class="name-list-container">
	<table id="name-list" class="show-table">
		<tr>
			<th>Name</th>
			<th>Credit?</th>
			<th>Dues?</th>
			<th>Details</th>
		</tr>
		<?php
		foreach($everyone as $person)
		{
			extract($person);
			echo "<tr><td>";
			forms_hidden('user[]', $user_id);
			echo "<span title=\"$class_nick Class\">$name</td><td>";
			forms_checkbox("credit[$user_id]", '1', $credit);
			echo "</td><td>";
			forms_checkbox("dues[$user_id]", '1', $dues);
			echo "</td><td>";
			forms_text(30, "details[$user_id]", $details);
			echo "</td></tr>";
		}
		?>
		<tr><td colspan="3"><?php forms_submit('Update', 'Update') ?></td></tr>
	</table>
</div>
</form>

<!-- this script automatically adds data-th attributes to all <td> -->
<!-- allows for <th> elements to show up responsively/in mobile views -->
<script src="/js/event_show_responsive_th.js"></script>

<?php
show_footer();
?>
