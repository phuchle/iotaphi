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




?>

	
<center> <b> <font size = "5"> WOW YOU LIAR... </font> </b></center>
<br>
<center>  <font size = "4"> That's not even your killer's killcode.  </font> </b></center>
<br>
<br>
<center> <iframe src="//giphy.com/embed/12XNRtl6kZxQVq?html5=true" width="480" height="345" frameBorder="0" class="giphy-embed" allowFullScreen></iframe> </center>
<br> <br>

 <center> <font size = "3"> Stop Tryna Cheat Dude...Jeez  </font> </center>
<br>
<br>




<center> 
<br>
<a href = "home.php"> I am a Loser Liar And Didn't Kill Anyone</a>
<br>
<br>
</center>
<?php show_footer(); ?>

