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



if($myInfo['alive']==0)
{
	header("Location:/assassins/f2k16/am_dead.php");
	exit(1);

}

?>


	
<center> <b> <font size = "5"> OMG YOU MURDER! </font> </b></center>
<br>
<center>  <font size = "4"> Did You Really Kill Your Best Friend <b> <?php echo $myTargetInfo['codename']?> </b> Though? </font> </b></center>
<br>
<br>
<center> <img src='http://www.iotaphi.org/images/profiles/<?php echo $myTargetInfo['user_id'];?>.jpg'> </center>
<br> <br>

 <center> <font size = "3"> Please Enter <?php echo $myTargetInfo['codename'];?>'s <b>EXACT</b> KillCode.  </font> </center>
<br>
<br>


<div align="center">
    <form method="post" action="input_killcode.php">
        <table>
            <tr>
                <td>
                    <label align="right">KillCode:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="text" name="killcode" required>
                    <sub>(Formating and Captilization Matters)</sub>
                </td>
            </tr>
            <tr>
                <td>
                    <label align="right">Exact Location of Kill:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="text" name="death_spot" required>
                    <sub>(Ex: Harring Hall, South Davis SafeWay)</sub>
                </td>
            </tr>
        </table>
    <br />
    <input type="submit" value="     I'm a Bad Person     " align="center"/>
    </form>
</div>





<center> 
<br>
<a href = "home.php"> Click Here If You're A Liar And Didn't Kill Anyone</a>
<br>
</center>
<?php show_footer(); ?>

