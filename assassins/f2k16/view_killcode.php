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


?>


<br><br>

<center>   
DO NOT SHARE THIS WITH ANYONE ELSE BESIDES THE ASSASSIN WHO KILLED YOU </center>

<br>

<center> Your Kill Code is: </center>

<br>
<br>

	<center> <font size = "3"> <b> "<?php echo $myInfo['killcode'];?>"  </b> </font> </center>
<br><br>


<center> Once You Have Been Assassinated, Share Your Kill Code With Your Killer To Confirm Your Death.</center>
<center>Exactly What is Inbetween the Quotes. Exact Formatting. Capitalization Matters.</center>

<br>
<br>

<center> 
<a href = "home.php"> Click Here To Go Back</a>
<br>
</center>
<a
<?php show_footer(); ?>

