<?php


function show_users($users)
{
	echo '<table cellspacing="1">';
	
	$COLS = 5;
	$ROWS = ceil(count($users)/floatval($COLS));
	
	// as long as there are at least 2 people then only the 3rd column can be invalid
	for($i = 0; $i < $ROWS; $i++)
	{
		// fill in all columns except the last
		for($j = 0; $j < $COLS - 1; $j++)
		{
			echo '<td class="small">';
			forms_checkbox('user[]' ,$users[$i+$j*$ROWS]['id']); 
			echo $users[$i+$j*$ROWS]['name'], '</td>';
		}
		
		// last column may not have a name in it
		echo '<td class="small">';
		if(isset($users[$i+($COLS-1)*$ROWS]))
		{
				forms_checkbox('user[]', $users[$i+($COLS-1)*$ROWS]['id']);
				echo $users[$i+($COLS-1)*$ROWS]['name'];
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

function show_profiles($users, $title='Users', $showPic=true, $columnsPerRow=3) //this is for user profiles, when you're trying to change their info
{
	if ( !is_array($users) )
	 $users = array ($users);
	 
	//retrieve info on all users selected
	$sql = "SELECT user_name, user_address, user_phone, user_cell, text_type, user_email, family_name,"
	. " class_name, user_aim, user_bday, shirt_size, user_id FROM user NATURAL JOIN family "
	. " NATURAL JOIN shirt NATURAL JOIN class NATURAL JOIN text"
	. " WHERE user_id IN (" . implode(',', $users) . ')';
	
	$userlist = db_select($sql, "show_profiles() couldn't get user data" );
	
	$i=0;
	echo '<table><tr><td class="heading" colspan="';
	if (count($userlist) > 2)
		echo $columnsPerRow;
	else
		echo count($userlist);
	echo "\">$title</td>";
		
	//now display information on each user selected
	foreach ($userlist as $candidate)
	{
		if ($i % $columnsPerRow == 0)	//New row if we've reached the max users per row
			echo "</tr>\n<tr>";
			
		echo "<td><table><tr><th colspan=\"2\"><input name=\"user[]\" type=\"checkbox\" value="
		. "\"{$candidate['user_id']}\" /> {$candidate['user_name']}</th></tr>\n";
		
		if ($showPic)
			echo "<tr><td colspan=\"2\"><img src=\"/images/profiles/{$candidate['user_id']}.jpg\""
		. "width=\"160\" height=\"200\"/></td></tr>\n"; //profile pic
		
		echo "<tr><td>Address:</td><td>{$candidate['user_address']}</td></tr>\n"
		. "<tr><td>Primary Phone:</td><td>{$candidate['user_cell']}</td></tr>\n"
		. "<tr><td>Text Type:</td><td>{$candidate['text_id']}</td></tr>\n"
		. "<tr><td>Email:</td><td>{$candidate['user_email']}</td></tr>\n"
		. "<tr><td>AIM:</td><td>{$candidate['user_aim']}</td></tr>\n"
		. "<tr><td>Birthday:</td><td>".date('n/j/Y', strtotime($candidate['user_bday']))."</td></tr>\n"
		. "<tr><td>Family:</td><td>{$candidate['family_name']}</td></tr>\n"
		. "<tr><td>Class:</td><td>{$candidate['class_name']}</td></tr>\n"
		. "<tr><td>Shirt Size:</td><td>{$candidate['shirt_size']}</td></tr>\n"
		. "</table></td>";
		
		$i++;
	}
	
	echo "</tr></table>\n";
}
function show_filters() //This is a filter status to where the current array is called, though it needs to be expanded
{
	?>
    <form>
	    <div class="general" style="width: 150px;">
		    <font class="big">Status Filter: </font>
		    <select name="filters" onchange="peopleFilter(this.value)" style="margin: 0px; padding: 0px">
		        <option value="0">Signed Up</option>
		        <option value="1">Non-Pledges</option>
		        <option value="2">Pledges</option>
		        <!-- option 3 needs to be fixed -->
		       <!-- <option value="3">Everyone</option> -->
		    </select>
	    </div>
    </form>
    
    <div class="name-search">
	    <p>Search Names:</p>
	  	<input type="text" id="nameInput" onkeyup="filterByNameInTable()" placeholder="Enter first or last name">
  	<div>
  	<!-- see code below -->
  	<div class="exportExcel">
  		<p>Export this table to an .xls format:</p>
	  	<button id="btnExport" class="btn btn-small">Export to Excel file</button>
  	</div>

	<script type="text/javascript">
		users = Array();
		<?php 
		$sql = 'SELECT user_id, user_name AS name, status_id '
			. " FROM user WHERE user_hidden = '0' ";
		foreach(db_select($sql) as $user)
		    echo "users['r'+'{$user['user_id']}'] = {status: {$user['status_id']} };";
		?>

	// added Jan. 2017 by Phuc Le
	// general function to search for names in tables
	// add name-list as table ID to make this work
		function filterByNameInTable () {
			var input, searchTerm, table, tr, td, i;

			input = document.getElementById("nameInput");
			searchTerm = input.value.toUpperCase();
			table = document.getElementById("name-list");
			tr = table.getElementsByTagName("tr");

			for (i = 0; i < tr.length; i++) {
				// if more than one td, increment below to search in another td
				// assumes name is in the first td
				td = tr[i].getElementsByTagName("td")[0];
				if (td) {
					if (td.innerHTML.toUpperCase().indexOf(searchTerm) > -1) {
						tr[i].style.display = "";
					}
					else tr[i].style.display = "none";
				}
			}
		}
	
		function peopleFilter(filter)
		{
			var pledge;
			var element;
			var attended;

			var rows = document.getElementById('name-list').rows;
			var count = 0;
			
			for(var row in rows)
			{
				element = rows[row];
				var i = element.id;
				count++;
				
				// skip the heading row and any erroneous rows
				if(users[i] == null)
					continue;
				
				pledge = (users[i].status == <?= STATUS_PLEDGE ?>);
				attended = (users[i].attended == true);
				
				if(filter == 3)
				{
					if(attended)
						element.style.display = "";
					else
						element.style.display = "none";
					continue;
								pledge = (users[i].status == <?= STATUS_ACTIVE ?>);			
					attended = (users[i].attended == true);
				}

				if((pledge && filter==1) || (!pledge && filter==2))
					element.style.display = "none";
				else
					element.style.display = "";
			}
		}

		// Exports table data by targeting the wrapper variable, table_div
		$(document).ready(function() {
			// pages on website where the export button will appear
			var validExcelExportPages = [
				"/tracking/service/totals.php",
				"/tracking/fellowship/totals.php",
				"/tracking/ic/totals.php",
				"/tracking/leadership/totals.php",
				"/tracking/caw/totals.php",
				"/tracking/meeting/totals.php",
				"/tracking/comms.php",
				"/tracking/usertotals.php",
				"/tracking/service/overview.php",
				"/tracking/service/this_term_events.php"
			];

			$( ".exportExcel" ).toggle(
		    $.inArray( location.pathname, validExcelExportPages ) >= 0
			);
		  $("#btnExport").click(function(e) {
		    e.preventDefault();

		    //getting data from our table
		    var data_type = 'data:application/vnd.ms-excel';
		    var table_div = document.getElementById('name-list-container');
		    var table_html = table_div.outerHTML.replace(/ /g, '%20');

		    //date for the file
			  var dt = new Date();
		    var day = dt.getDate();
		    var month = dt.getMonth() + 1;
		    var year = dt.getFullYear();
		    var postfix = day + "-" + month + "-" + year;

		    var a = document.createElement('a');
		    a.href = data_type + ', ' + table_html;
		    a.download = 'exported_table_' + postfix + '.xls';
		    a.click();
		  });
		});
	</script>
<?
}


function show_filter()
{
	?>
    <form>
    <div class="general" style="width: 150px;">
    <font class="big">Status Filter: </font>
    <select name="filters" onchange="peopleFilter(this.value)" style="margin: 0px; padding: 0px">
        <option value="0">Everyone</option>
        <option value="1">Non-Pledges</option>
        <option value="2">Pledges</option>
    </select>
    </div></form>
    
	<script type="text/javascript">
	users = Array();
	
	<?php 
	$sql = 'SELECT user_id, user_name AS name, status_id '
		. " FROM user WHERE user_hidden = '0' ";
	foreach(db_select($sql) as $user)
	    echo "users['r'+'{$user['user_id']}'] = {status: {$user['status_id']} };";
	?>
	
	function peopleFilter(filter)
	{
		var pledge;
		var element;
		var attended;

		var rows = document.getElementById('name-list').rows;
		var count = 0;
		
		for(var row in rows)
		{
			element = rows[row];
			var i = element.id;
			count++;
			
			// skip the heading row and any erroneous rows
			if(users[i] == null)
				continue;
			
			pledge = (users[i].status == <?= STATUS_PLEDGE ?>);
			attended = (users[i].attended == true);
			
			if(filter == 3)
			{
				if(attended)
					element.style.display = "";
				else
					element.style.display = "none";
				continue;
			}
			if((pledge && filter==1) || (!pledge && filter==2))
				element.style.display = "none";
			else
				element.style.display = "";
		}
	}
	</script>
<?
}

// Change the raw phone number into a nicely formatted one
function show_phone($int)
{
    if(strlen($int) == 10)
    {
        $new_phone = '';
        $new_phone .= '(' . substr($int, 0, 3) . ')';
        $new_phone .= substr($int, 3, 3) . '-';
        $new_phone .= substr($int, 6);
        return $new_phone;
    }
    else
        return $int;
}

function build_users()
{
	?>
	<script type="text/javascript">
	var users = Array();
	
	<?php 
	$sql = 'SELECT user_id, user_name AS name, class_nick '
		. " FROM user NATURAL JOIN class "
        . " WHERE status_id NOT IN (".STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_INACTIVE.','.STATUS_ALUMNI.','.STATUS_ADMINISTRATOR.','.STATUS_DEACTIVATED.") AND user_hidden = '0' ";
	echo 'users = [';
	foreach(db_select($sql) as $user)
	{
		if($notfirst++)
			echo ",\n ";
		echo " { id:{$user['user_id']}, class:'{$user['class_nick']}', ",
             " name:'{$user['name']}' } ";
	}
	echo '];';
	?>
	</script>
<?
}
?>
