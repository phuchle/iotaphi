<?php

include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();

if(isset($_GET['id']))
	$user = $_GET['id'];
	
if(isset($_SESSION['id'])) 
	$id = $_SESSION['id'];
else 
{
	echo "Yo you gotta sign in man." ;
	exit(1);
}
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

show_header();
$myID = $id;


function get_player_info($tempID)
{
	$sql = "SELECT * FROM assassins2k16 NATURAL JOIN user WHERE user_id='$tempID'";
			
	$result = mysql_query($sql) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result);
}


$myInfo = get_player_info($myID);

if(isset($myInfo['user_id'])==0)
{
	header("Location:/assassins/2k16/not_signedup.php");
	exit(1);
}




$target_id = $myInfo['current_target'];


function get_target_info($tempID)
{
	$sql2 = "SELECT * FROM assassins2k16 NATURAL JOIN user WHERE user_id='$tempID'";
			
	$result2 = mysql_query($sql2) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result2);
}

$myTargetInfo = get_target_info($target_id);


function update_kills($tempID, $killcount)
{
	$sql3 = "UPDATE `assassins2k16` SET `num_kills` = '$killcount' WHERE `assassins2k16`.`user_id` = $tempID";
			
	$result3 = mysql_query($sql3) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result3);
}

function update_total_kills($tempID, $killcount)
{
	$sql3 = "UPDATE `assassins2k16` SET `alive` = '$killcount' WHERE `assassins2k16`.`user_id` = $tempID";
			
	$result3 = mysql_query($sql3) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result3);
}

function update_death($tempID)
{
	$sql4 = "UPDATE `assassins2k16` SET `alive` = '0' WHERE `assassins2k16`.`user_id` = $tempID";
			
	$result4 = mysql_query($sql4) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result4);
}

function update_target($myid, $ememy_id)
{
	$sql5 = "UPDATE `assassins2k16` SET `current_target` = '$ememy_id' WHERE `assassins2k16`.`user_id` = $myid";
			
	$result5 = mysql_query($sql5) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result5);
}

function update_lastest_killed2($just_died)
{

	$sql6 = "UPDATE `assassins2k16` SET `killcode` = '$just_died' WHERE `assassins2k16`.`user_id` = 2834;";
			
	$result6 = mysql_query($sql6) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result6);
}

function update_death_spot($target, $input_deathspot)
{

	$sql7 = "UPDATE `assassins2k16` SET `death_spot` = '$input_deathspot' WHERE `assassins2k16`.`user_id` = $target;";
			
	$result7 = mysql_query($sql7) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result7);
}

function update_death_time($target, $time1)
{

	$sql7 = "UPDATE `assassins2k16` SET `death_time` = '$time' WHERE `assassins2k16`.`user_id` = $target;";
			
	$result7 = mysql_query($sql7) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result7);
}




$input_killcode = $_POST['killcode'];
$input_death_spot = $_POST['death_spot'];

if($input_killcode == $myTargetInfo['killcode'])
{

	?> <center> <b> <font size = "5"> OMG YOU SAVAGE! </font> </b></center>
<br>
<center>  <font size = "4"> Because of you, <b> <?php echo $myTargetInfo['codename']?> </b> is now dead. </font> </b></center>
<br>
<center>  <font size = "4"> ARE YOU HAPPY NOW HUH. YOU MONSTER </font> </b></center>

<br>

<center> NOW TAKE ONE LAST HARD LOOK AT THE PERSON YOU ROBBED OF A FREE BANQUET TICKET </b></center>
<br>
<center> <img src='http://www.iotaphi.org/images/profiles/<?php echo $myTargetInfo['user_id'];?>.jpg'> </center>
<br>


<center> 
<br>
<a href = "home.php"> Click Here To Return Home and View Your New Target</a>
<br>
</center>


<?php 


$name = 2834;

$kevin_stats = get_player_info($name);
$old_total_deaths = $kevin_stats['alive'];

//echo "asd $kevin_stats[user_id]";
$new_total_deaths = $old_total_deaths + 1;

//update total kills
update_total_kills($kevin_stats['user_id'],$new_total_deaths);


//update_latest_killed
update_lastest_killed2($myTargetInfo['codename']);



$old_kill_count = $myInfo['num_kills'];
$new_kill_count = $old_kill_count + 1;

//give the user +1 kills
update_kills($myInfo['user_id'], $new_kill_count);
//set death player to alive = 0
update_death($myTargetInfo['user_id']);
//gives new target to user
update_target($myInfo['user_id'], $myTargetInfo['current_target']);

//update dead person's death spot
update_death_spot($myTargetInfo['user_id'], $input_death_spot);

//update death_time
$time2 = date("D M d, Y G:i a"); 
echo $time2;
update_death_time($myTargetInfo['user_id'], $time2);



}
else
{
	header("Location:/assassins/2k16/liar_killcode.php");
	exit(1);
}

?>

	

<?php show_footer(); ?>