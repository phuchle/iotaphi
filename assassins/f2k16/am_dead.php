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
	$sql2 = "SELECT * FROM assassinsf2k16 NATURAL JOIN user WHERE user_id='$tempID'";
			
	$result2 = mysql_query($sql2) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result2);
}

$myTargetInfo = get_target_info($target_id);




?>


<center> <b> <font size = "5"> YOU DIED ALREADY?! LOL SUCKS TO SUCK. </font> </b></center>
<br>
<center><font  size = "4"> Thanks For Playing In This Term's Assassins. </font></center>
<br>
<br>
<center><font  size = "3"> You when you thought u were gonna to go Banquet for Free... </font>
<br><font  size = "3"> then your face when you died</font></center><br>
<center> <img src='died.gif'> </center>
<br> <br>
<br>
 <center> <font size = "3"> Better Luck Next Time! </font> <br><br> 
 or <br> <br>
 <big><b>COME THRU TO THE FREE-FOR-ALL DEATHMATCH </b></big>
 <br> <b><font size = "3" >NOV 20TH. BE THERE OR BE SQUARE.</font></b> </center>
<br>
<br>


<center>
<br> 
<br>
<a href = "home.php"> Click Here To Return</a>
<br>
</center>
<?php show_footer(); ?>

