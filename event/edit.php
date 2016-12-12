<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

$page = $_GET['page'];
$event_id = $_GET['event_id'];

if(isset($_GET["date"]))
	$eventDate = $_GET["date"];
else
	$eventDate = "";

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();

// must take an array for $event
// $event is array of columns in the event database table
// this func is called at the bottom of this file
function show_eventModify($new, $event)
{ 
	// fill maybe with event info
	if($new==false):
		$event = event_get($event['id']);
		$event['time'] = date('g:ia',$event['date']);
		$seconds = $event['enddate'] - $event['date'];
		$minutes = (int)($seconds / 60);
		$hours = (int)($minutes / 60);
		$minutes %= 60;
		if($minutes<10)
			$minutes = '0'.$minutes;
		$event['duration'] = $hours . ':' . $minutes;
		$event['date'] = date("m/d/Y",$event['date']);
		$event['c'] = fourC_get($event['id']);
	else:
		$event['duration'] = '0:00';
		$event['description'] = "";
		$event['location'] = "";
		$event['mileage'] = 0;
		$event['contact'] = "";
		$event['custom1'] = "";
		$event['custom2'] = "";
		$event['custom3'] = "";
		$event['custom4'] = "";
		$event['custom5'] = "";
	endif;
?>

<script type="text/javascript">
	// adds date fields to allow adding multiple events at once
	// Added by Phuc Le Dec. 2016
	function addDate() {
		var date_container = document.getElementById('event_date_fields');
		
		var newSpan = document.createElement('span');
		newSpan.innerHTML = '<br/> <input name="date[]" type="text" size="10" id="date[]" maxlength="10"> ';

		date_container.appendChild(newSpan);
	}
</script>

	<form name="event" onsubmit="return valid(this)" 
        method="POST" action="/inputAdmin.php">

	<?php
		forms_hiddenInput($new ? "eventCreate" : "eventUpdate", "/calendar.php"); 
	?>

	<?php forms_hidden('event_id', $event['id']); ?>
	
	<table id="eventTable" class="table table-condensed table-bordered">
	<tr>
		<td class="lead" colspan="3">Edit Event</td>
	</tr>
	<tr>
		<th>Name<br></th>
		<td><?php forms_text_required(40,"name",$event['name']); ?></td>
		<td></td>
	</tr>
	<tr>
		<th>Date<br></th>
		<td id="event_date_fields">
		<!-- date[] will POST as 'date' => date[0], date[1], etc  -->
			 <?php forms_date('date[]',$_GET["date"],'event.date') ?>
		</td>
		<td>MM/DD/YYYY<br>eg 09/12/2004</td>
	</tr>
	<tr>
		<td>
			<input type="button" class="btn btn-small"" onclick = "addDate();" value="Add Another Date" />
		</td>
	</tr>
	<tr>
		<th>Time<br></th>
		<td><?php forms_time("time",$event['time']) ?></td>
		<td>HH:MM (am|pm)<br>eg 12:34pm</td>
	</tr>
	<tr>
		<th>Duration<br></th>
		<td>
			<?php forms_duration('duration',$event['duration']) ?>
		</td>
		<td>H:MM<br>eg 1:30<br>(0:00 is unspecified)</td>
	</tr>
	<tr>
		<th>Location<br></th>
		<td>
			<?php forms_textarea('location',
                    str_replace("\n",'',$event['location'])) ?>
		<td>
		</td>
	</tr>
	<tr>
		<th>Address [for driving directions]<br /></th>
		<td>
			<?php forms_textarea('address',
                    str_replace("\n",'',$event['address'])) ?>
		</td>
	</tr>
	<tr>
		<th>Map<br></th>
		<td>
			<? forms_textarea('map',str_replace("\n",'',$event['map']));
			?>
		<td></td>
	</tr>
<?php
	if ($new || $event['type'] == 'Service' || $event['type'] == 'Fellowship')
	{ ?>
	<tr>
		<th>Trip Mileage<br></th>
		<td>
			<?php forms_text(4,"mileage",$event['mileage']); ?> miles
		</td>
		<td></td>
	</tr>
<?php
	} else { 
		forms_hidden("mileage",0);
	}
?>
	<tr>
		<script type="text/javascript">
		var oldValue = <?php echo $event['typeid']?$event['typeid']:'1' ?>;

		// shows or hides the four Cs of service
		function fourC()
		{
			var mySelect = document.getElementById('eventTypeSelect');
			var myTable = document.getElementById('eventTable');
			var row = document.getElementsByName('fourCSelect');
			if(mySelect.value==1) // service
				for (var i = 0; i < row.length; i++) {
					row[i].style.display = 'inline-block';
				}
			else
				for (var i = 0; i < row.length; i++) {
					row[i].style.display = 'none';
				}
		}
		</script>

		<th>Type<br></th>
		<td><select id="eventTypeSelect" size="1" name="type" onchange="fourC()">
		<?php
		$types = eventtype_getAll();
		foreach($types as $line)
		{ 
			$selected = ($event['typeid']==$line['id']?'selected':'');
			echo "<option $selected value=\"{$line['id']}\">{$line['name']}</option>";
		} ?>
		</select></td>
		<td></td>
	</tr>
	<tr>
		<th>Four C's</th>
		<td name="fourCSelect">
			<?php forms_radio('c','0', ($event['c']=='Chapter')) ?>Chapter
			<?php forms_radio('c','1', ($event['c']=='Campus')) ?>Campus
			<?php forms_radio('c','2', ($event['c']=='Community')) ?>Community
			<?php forms_radio('c','3', ($event['c']=='Country')) ?>Country
		</td>
	</tr>
	<script type="text/javascript">
		fourC();
	</script>
	<tr>
		<th>IC<br></th>
		<td>
			<?php forms_radio('ic', '0', ($event['ic']==false) ) ?>No&nbsp;&nbsp;&nbsp;&nbsp;
			<?php forms_radio('ic', '1', ($event['ic']==true) ) ?>Yes!
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Fundraiser<br></th>
		<td>
			<?php forms_radio('fund', '0', ($event['fund']==false) ) ?>No&nbsp;&nbsp;&nbsp;&nbsp;
			<?php forms_radio('fund', '1', ($event['fund']==true) ) ?>Yes!
		</td>
		<td></td>
	</tr>	
	<tr>
		<th>Fellowboat<br></th>
		<td>
			<?php forms_radio('fellowboat', '0', ($maybe['fellowboat']==false) ) ?>No&nbsp;&nbsp;&nbsp;&nbsp;
			<?php forms_radio('fellowboat', '1', ($maybe['fellowboat']==true) ) ?>Yes!
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Description<br></th>
		<td>
			<?php forms_textarea('description',str_replace("\n",'',$event['description'])) ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Event Contact<br></th>
		<td>
			<?php forms_textarea('contact',str_replace("\n",'',$event['contact'])) ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Additional Info</th>
		<td>
			<?php forms_text(50,"custom1",$event['custom1']); ?><br />
			<?php forms_text(50,"custom2",$event['custom2']); ?><br />
			<?php forms_text(50,"custom3",$event['custom3']); ?><br />
			<?php forms_text(50,"custom4",$event['custom4']); ?><br />
			<?php forms_text(50,"custom5",$event['custom5']); ?>
		</td>
		<td>Additional info you want from people when they sign up.<br />
			eg What time can you leave?<br />
			eg How many passengers can you take?
		</td>
	</tr>
	<tr>
		<th>So Hot Right Now</th>
		<td>
			<?php forms_checkbox('hot',1,($event['hot']==1)); ?>
		</td>
		<td>This event is sooo hot right now! (It will be linked from the home page.)
		</td>
	</tr>
	<tr><td class="out">
	<?php 
	forms_submit($new?'Create':'Update', ''); ?>
	</td></tr>
	</table>
	</form>
<?php 
}

// permissions?
if($class!="admin")
	show_note('You must be an administrator to access this page.');

// create or update?
if($page == "update"):
	$defaults = array();
	$defaults['id'] = $event_id;
	show_eventModify(false,$defaults);
elseif($page == "create"):
	$defaults = array();
	// removed so that an array of dates can be POSTed rather than just 1 date
	// $defaults['date'] = $eventDate;
	show_eventModify(true,$defaults);
endif;

show_footer(); 
?>
