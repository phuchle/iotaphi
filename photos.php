<?php 
include_once 'include/template.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	else
{
	print "
	
	<div> 
	<img src='http://www.iotaphi.org/wp-content/uploads/2012/02/henry.jpeg'>
	<br>
	Sorry bro, you are not a member, uh, eh, maybe you are! 
	<br>
	If you're a new member or if you want to reset your password:  <a href='http://www.iotaphi.org/forgetful/index.php'>Click Here</a> Jolly Good!
	";
	show_footer(); 
	exit;
}
?>
<?php
	if($_SESSION['class']) { // Only show right column if logged in
?>
<head>
<body>
<iframe src="http://iotaphi.smugmug.com" height = "450px" width = "100%">
</body>
</head>
</iframe>
<?php }
show_footer(); 
?> 