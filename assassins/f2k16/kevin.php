<?php

include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';    

if(isset($_GET['id']))
{
	echo "got ID\n" ; 
	$user = $_GET['id'];

}

if(isset($_SESSION['id'])) 
{
	//echo "got session\n";
	$id = $_SESSION['id'];
	//$user = $_SESSION['user'];
	//echo "$id";
	//echo "$user";

show_header();

echo "id = $id\n";

//$user = user_getUsername($id) or die("Cannot Not Find User!");

//echo " asdf asadf $user" ; 



//dp_open();
?>






<table width=98%>
	<tr>
		<td colspan=3 class="heading">Assassins</td>
	</tr>
	<tr>
		<td colspan=3><p>Welcome to IPhi S2K16 Assassins!</p>
		<p>To report any assassins who break <a href="rules.php">the Code</a>, please contact <a href="http://www.iotaphi.org/people/profile.php?user=2835">Jose Torres</a> or <a href="http://www.iotaphi.org/people/profile.php?user=2834"> Kevin Dinh. </a></p></td>

</tr>
	<tr>
		<td colspan=3>
			<a href="admin.php">Click here to moderate.</a><br/>
			<a href="player.php">Click here for your mission info.</a>
		</td>
	</tr>
	<tr>
		<th colspan=2>
			<p>Announcements</p>
		</th>
	</tr>
	<tr>
		<td colspan=2><p> 5/12/2016 The assassins page is currently under construction, please be patient while we update the code and add players to the game. Happy Hunting!
		</td>
	</tr>
	<tr>
		<td colspan=2>
		<table width=100%>
			<?php $deathslist = get_yesterdays_deaths(); ?>
			<tr>
				<th width=100%>Yesterday's Deaths</th>
			</tr>
		<?php if (!$deathslist){ ?>
			<tr>
				<td>No deaths yesterday.</td>
			</tr>

		<?php }
		else {
		$index = count($deathslist) + 1;
		foreach($deathslist as $ass)
		{
			$index--;
			$counter = 0;
			if($ass['killer_id'])
			{
				$killer = get_player_info($ass['killer_id']);
				if($killer['alive'] && $killer['hiding'])
					$killer_name = "Someone";
				else $killer_name = $killer['codename'];
			}
			else
				$killer_name = "God";
			$killed = get_player_info($ass['killed_id']);
			$killed_name = $killed['codename'];
			switch ($ass['weapon_id']) {
				case 1:
					$method = " shot ";
					break;
				case 2:
					$method = " stabbed ";
					break;
				case 3:
					$method = " struck down ";
					break;
			} ?>
			<tr>
				<td><?php
					if($ass['obit_story']!="")
					{
						echo "<a href=\"showobit.php?story=".$ass['obit_id']."\">";
					}
					echo $index.". ".$killed_name; ?>
					<?php if($ass['obit_story']!="") echo "</a>"; ?> </td>
			</tr>
		<?php 	$counter++;
			
		} }?>
		</table>
		</td>
	</tr>
	<tr>
		<td width=50%>
		<table width=100%>
			<tr>
				<th>Bloodiest Assassins</th>
			</tr>
			<tr>	
				<td align="center"><img src="deadly.php" /></td>
			</tr>
		</table>		
		</td>
		<td width=50%>
		<table width=100%>
			<tr>
				<th>Chance of Multiple Killers</th>
			</tr>
			<tr>	
				<td align="center"><img src="hunted.php" /></td>
			</tr>
		</table>		
		</td>
	</tr>
	<tr>
		<td width=50%>
		<table width=100%>
			<tr>
				<th>Kills by Time of Day</th>
			</tr>
			<tr>	
				<td align="center"><img src="day.php" /></td>
			</tr>
		</table>
		</td>
		<td width=50%>
		<table width=100%>
			<tr>
				<th>Kills by Day of Week</th>
			</tr>
			<tr>	
				<td align="center"><img src="week.php" /></td>
			</tr>
		</table>
		</td>
	</tr>
</table>	

<?php show_footer(); 

}

else
	show_note('You are not logged in.'); ?>
