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


?> <center> <font size = "5">  <b> Assassin Players F2K16 </b> </font> </center> 

<br><br>



<br>




<?php


$sql = "SELECT user_id FROM `assassinsf2k16`"; 
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