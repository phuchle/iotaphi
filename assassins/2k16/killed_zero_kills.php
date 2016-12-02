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


    
<center> <b> <font size = "5"> DID YOU REALLY KILL SOMEONE THO? </font> </b></center>
<br>
<center>  <font size = "4"> Cause Don't Be Lying... </font> </b></center>
<br>
<br>
<center> <iframe src="//giphy.com/embed/5pTRy8Q67nOOA?html5=true" width="480" height="372" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></center>
<br> <br>

 <center> <font size = "3"> Please Enter The Person You Killed's <b> EXACT</b> Killcode  </font> </center>
<br>
<br>


<div align="center">
    <form method="post" action="input_killed_zero.php">
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

