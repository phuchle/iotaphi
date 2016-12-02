<?php

include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();

if(isset($_SESSION['id']))
  $user = $_SESSION['id'];
else
{
  print "You are not logged in.";
  show_footer();
  exit;
}

if(isset($_SESSION['class']))
  $class = $_SESSION['class'];

if(isset($_GET['user']))
  $user_id = (int)$_GET['user'];


?> <center> <font size = "5">  <b> HURRY UP AND KILL THEM </b> </font> </center> 

<br><br>



<br>



<?php


$sql = "SELECT user_id FROM `assassins2k16` WHERE alive = 1 ORDER BY RAND()"; 
$result = mysql_query($sql) or die("Query Failed!". mysql_error()); 
$count = 0;

while( $row=mysql_fetch_row($result) )
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

}//while


?>



<br>
<br>
<br>

<br>
<br>
<center><big><a href="home.php">Click Here For Free Ice Cream</a></big></center>
<br>
<br>