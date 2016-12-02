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



if($myInfo['alive']==0)
{
 /* 
  ?> <center>SORRY U DED ): SINCE WE FEEL BAD FOR YOU, YOU CAN NOW KILL SOME ONE. <br> You still kinda suck though...</center>

  <?php*/

  header("Location:/assassins/f2k16/am_dead.php");
  //exit(1);

}


$target_id = $myInfo['current_target'];


function get_target_info($tempID)
{
  $sql2 = "SELECT * FROM assassinsf2k16 NATURAL JOIN user WHERE user_id='$tempID'";
      
  $result2 = mysql_query($sql2) or die("Query Failed (get_player_info)! ". mysql_error());
  
  return mysql_fetch_assoc($result2);
}


function get_no_kills()
{
  $sql = "SELECT * FROM `assassinsf2k16` WHERE `num_kills` = 0 AND `alive` = 1; # OR `num_kills` = 0 AND `alive` = 1"; 
  $result = mysql_query($sql) or die("Query Failed!". mysql_error()); 

  return $result;
}



$myTargetInfo = get_target_info($target_id);




if($myInfo['alive']==1)
{

  ?>

<center> <b> <font size = "5"> Your Current MAIN Target Is </font> </b></center>
<br>
<center><font  size = "4"> <?php echo $myTargetInfo['codename']; ?> </font></center>
<br>
<center> <img src='http://www.iotaphi.org/images/profiles/<?php echo $myTargetInfo['user_id'];?>.jpg'> </center>
<br> <br>

 <center> <font size = "3"> Your Target May Look Pretty But Be Careful, <b> <?php echo $myTargetInfo['codename'];?> </b> Already Has <?php echo $myTargetInfo['num_kills'];?> kills! </font> </center>
<br>
<br>


<center>
<br> 
<a href = "confirm_kill.php"> Click Here If You Killed Your MAIN Target: <?php echo $myTargetInfo['codename'];?> </a> </center>
<br> 
<br>
<br>
<?php
} 
?>
<br>
<br>
<center><b> <font size = '4'> You Can Now Kill Anyone of These Assassins With Less Than 2 Kills: </b></center></font>
<br>
<br>
<?php 

$no_kills_people = get_no_kills();

while( $row=mysql_fetch_row($no_kills_people) )
  
{ 
    

  ?> 
      <img src='http://www.iotaphi.org/images/profiles/<?php echo $row[0]?>.jpg'>

      &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;

   <?php 

   $count++; 

    if($count ==5 )
   {
    echo "<br><br>";
    $count = 0;
   }

   $total_count = $total_count + 1;

}//while




?>

<br>
<br>
<br>

<big> <center> <a href = "killed_zero_kills.php"> Click Here If You Killed Someone With Less Than <font color = 'red'> Two </font> Kill</a> </big>
<br>
<br>
<br>
<a href = "home.php"> Click Here To Return</a> </center>
<br>
</center>
<?php show_footer(); ?>

