<?php 
include_once dirname(dirname(__FILE__)) . '/include/database.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
db_open();

if(isset($_POST['searchname']))
{
	$testname = strtolower($_POST['searchname']);
	$testname = str_replace(" ","",$testname);
	$testname = str_replace("%20","",$testname);

	$sql = "SELECT user_name AS name, user_password AS password, user_id AS id FROM user WHERE status_id=0 OR status_id=1 OR status_id=8 OR user_id=1520";
	$pledges = db_select($sql);
	foreach($pledges as $pledge)
	{
		$checkname = strtolower($pledge['name']);
		$checkname = str_replace(" ","",$checkname);

		if($checkname==$testname)
		{
			$pinfo = user_get($pledge['id'], 'fF');
		}
	}
}
	
	switch($pinfo['family'])
	{
		case 1:
			$pfamily = "TIGHT";
			$pfont = "Impact";
			break;
		case 2:
			$pfamily = "CLOSE";
			$pfont = "Showcard Gothic";
			break;
		case 3:
			$pfamily = "LOOSE";
			$pfont = "Pristina";
			break;
		case 4:
			$pfamily = "CHEN";
			break;
		case 5;
			$pfamily = "LOSER";
			break;
		case 6;
			$pfamily = "BANANA";
			break;
		case 7;
			$pfamily = "THOT";
			break;

	}

switch($pinfo['family'])
	{
		case 1:
			$pfamilies = "#DF3D29";
			break;
		case 2:
			$pfamilies = "#54DF24";
			break;
		case 3:
			$pfamilies = "#127AAF";
			break;
		case 6;
			$pfamilies = "Yellow";
			break;
		case 7:
			$pfamilies = "Fuchsia";
			break;
	}
				
			
?>






<body style="background-color: <?php echo $pfamilies; ?>" >
<div>
<center><font style="color:black; font-size:100px; font-family: Brush Script MT"> Welcome to <font style="font-family: <?php echo $pfont; ?>"><?php echo $pfamily; ?></font>
 family!<br/><img src="
<?php
	echo strtolower($pfamily);
	echo 5;
?>.gif">
</br></font>
<font style="font-size:85px; color:black; font-family: <?php echo $pfont; ?>		";>
 <?php echo $pinfo['name']; ?>
 </font>
</center>
</div>
<br>
<center>
<br>
<a href = "search.php"> Go Back </a>
</center>
</body>
</html>
<?php 
// close session first so we can close the db
session_write_close();
db_close();

?> 

