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


?> 



<center><font size=5> <b> Assassins Hall of Fame </b>  </font><br><br> <font size=3>	Nishiya-Milligan S2K16 Winner </font> <br><br> <img src="http://www.iotaphi.org/images/profiles/2976.jpg">

<br> <b>HeWentToJared</b>
<br> Jared Anderson
<br> Kills: Too Many
<br> Date: 5/26/2016

<br><br><br>
_________________
<br><br><br>

<audio id="bflat" src="Victory_Screech.mp3"></audio>
<button onclick="document.getElementById('bflat').play()">Celebrate Victory</button>

</center>


<?php
show_footer();
?>

