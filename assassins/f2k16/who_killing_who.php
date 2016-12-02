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
  header("Location:/assassins/f2k16/am_dead.php");
  exit(1);

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
  $sql = "SELECT * FROM `assassinsf2k16` WHERE `alive` = 1 AND `num_kills` = 0"; 
  $result = mysql_query($sql) or die("Query Failed!". mysql_error()); 

  return $result;
}



function get_alive()
{
  $sql = "SELECT * FROM `assassinsf2k16` WHERE `alive` = 1"; 
  $result = mysql_query($sql) or die("Query Failed!". mysql_error()); 

  return $result;
}


function get_target($target_id)
{
  $sql = "SELECT * FROM `assassinsf2k16` WHERE `user_id` = $target_id"; 
  $result = mysql_query($sql) or die("Query Failed!". mysql_error()); 

  return $result;
}


$find_alive = get_alive();

?>



<center>
<br> 
<br> 
<br>
<br>
<br>
<br>
<center><b> <font size = '4'> Who is Killing Who: </b></center></font>
<br>
<br>
<?php 

while( $row=mysql_fetch_row($find_alive) )
  
{ 
    
  echo"$row[1] "

  ?> 

      <img src='http://www.iotaphi.org/images/profiles/<?php echo $row[0]?>.jpg'>

      &nbsp;&nbsp;&nbsp;&nbsp;

      is trying to kill &nbsp;&nbsp;

       <img src='http://www.iotaphi.org/images/profiles/<?php echo $row[6]?>.jpg'>

       <?php 

       $myTargetInfo = get_target($row[6]);
       $blah = mysql_fetch_row($myTargetInfo);
       echo "$blah[1] who is ";

       if($blah[4] == 1)
        echo "<b> ALIVE </b>";
      if($blah[4]==0)
          echo "<b> DEAD </b>";


       ?>

       <br>
       <br>


   <?php 

   $total_count = $total_count + 1;

}//while



?>
<br >
total alive = <?php echo $total_count ?>
<br>
<br>
<br>
<br>
<br>


<?php
while( $row2=mysql_fetch_row($find_alive) )
  
{ 
    

  ?> 
      <img src='http://www.iotaphi.org/images/profiles/<?php echo $row[0]?>.jpg'> 

      is trying to kill
      &nbsp;&nbsp;&nbsp;&nbsp;
      
      <img src='http://www.iotaphi.org/images/profiles/<?php echo $row[6]?>.jpg'> 
   <?php 


    echo "<br><br>";
    $count = 0;


}//while

?>

<br>
<br>
<a href = "home.php"> Click Here To Return</a>
<br>
</center>
<?php show_footer(); ?>

