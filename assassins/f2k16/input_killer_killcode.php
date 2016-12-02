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
	$sql = "SELECT * FROM assassinsf2k16 NATURAL JOIN user WHERE user_id='$tempID'";
			
	$result = mysql_query($sql) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result);
}


$myInfo = get_player_info($myID);

if(isset($myInfo['user_id'])==0)
{
	header("Location:/assassins/f2k16/not_signedup.php");
	exit(1);
}




$target_id = $myInfo['current_target'];


function get_target_info($tempID)
{
	$sql2 = "SELECT * FROM 'assassinsf2k16' NATURAL JOIN user WHERE user_id='$tempID'";
			
	$result2 = mysql_query($sql2) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result2);
}

$myTargetInfo = get_target_info($target_id);


function update_kills($tempID, $killcount)
{
	$sql3 = "UPDATE `assassinsf2k16` SET `num_kills` = '$killcount' WHERE `assassinsf2k16`.`user_id` = $tempID";
			
	$result3 = mysql_query($sql3) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result3);
}

function update_total_kills($tempID, $killcount)
{
	$sql3 = "UPDATE `assassinsf2k16` SET `alive` = '$killcount' WHERE `assassinsf2k16`.`user_id` = $tempID";
			
	$result3 = mysql_query($sql3) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result3);
}

function update_death($tempID)
{
	$sql4 = "UPDATE `assassinsf2k16` SET `alive` = '0' WHERE `assassinsf2k16`.`user_id` = $tempID";
			
	$result4 = mysql_query($sql4) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result4);
}

function update_target($myid, $ememy_id)
{
	$sql5 = "UPDATE `assassinsf2k16` SET `current_target` = '$ememy_id' WHERE `assassinsf2k16`.`user_id` = $myid";
			
	$result5 = mysql_query($sql5) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result5);
}

function update_lastest_killed2($just_died)
{

	$sql6 = "UPDATE `assassinsf2k16` SET `killcode` = '$just_died' WHERE `assassinsf2k16`.`user_id` = 3347;"; 
			
	$result6 = mysql_query($sql6) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result6);
}

function update_death_spot($target, $input_deathspot)
{

	$sql7 = "UPDATE `assassinsf2k16` SET `death_spot` = '$input_deathspot' WHERE `assassinsf2k16`.`user_id` = $target;";
			
	$result7 = mysql_query($sql7) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result7);
}

function update_death_time($target, $time1)
{

	$sql7 = "UPDATE `assassinsf2k16` SET `death_time` = '$time' WHERE `assassinsf2k16`.`user_id` = $target;";
			
	$result7 = mysql_query($sql7) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return $result7;
}

function find_my_killer($myid)
{
	
	$sql2 = "SELECT * FROM `assassinsf2k16` WHERE `current_target`= $myid";
			
	$result2 = mysql_query($sql2) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return $result2;
}



$find_killer = find_my_killer($myID);
$mykiller_info = mysql_fetch_row($find_killer);
$input_death_spot = $_POST['death_spot'];

//echo "my killer id = $mykiller_info[0]";

//echo"<br>";
$my_killer_id = $mykiller_info[0];
$find_killer_killer = find_my_killer($my_killer_id);

$kill2_info = mysql_fetch_row($find_killer_killer);



$input_killcode = $_POST['killer_killcode'];

if($input_killcode == $mykiller_info[5])
{
	?> <center> <b> <font size = "5"> OMG YOU SAVAGE! </font> </b></center>
<br>
<center>  <font size = "4"> Because of you, <b> <?php echo $mykiller_info[2]?> </b> is now dead. </font> </b></center>
<br>
<center>  <font size = "4"> ARE YOU HAPPY NOW HUH. YOU MONSTER </font> </b></center>

<br>

<center> NOW TAKE ONE LAST HARD LOOK AT THE PERSON YOU ROBBED OF A FREE BANQUET TICKET </b></center>
<br>
<center> <img src='http://www.iotaphi.org/images/profiles/<?php echo $mykiller_info['0'];?>.jpg'> </center>
<br>


<center> 
<br>
<a href = "home.php"> Click Here To Return Home. Your Target Will Remain the Same.</a>
<br>
</center>

<?php

$name = 3347;

$kevin_stats = get_player_info($name);
$old_total_deaths = $kevin_stats['alive'];

$new_total_deaths = $old_total_deaths + 1;

//update total kills
update_total_kills($kevin_stats['user_id'],$new_total_deaths);

//update_latest_killed
update_lastest_killed2($mykiller_info[2]);

$old_kill_count = $myInfo['num_kills'];
$new_kill_count = $old_kill_count + 1;

//give the user +1 kills
update_kills($myInfo['user_id'], $new_kill_count);



//set death player to alive = 0
update_death($mykiller_info[0]);


//gives new target to user
update_target($kill2_info[0], $myInfo['user_id']);

//update dead person's death spot
update_death_spot($mykiller_info[0], $input_death_spot);


}

else
{
	header("Location:/assassins/f2k16/liar_killer_killcode.php");
	exit(1);
}



?>

	

<?php show_footer(); ?>

