<?php
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';


//$sql = "SELECT class_id FROM class ORDER BY class_id DESC";
//$returned = db_select1($sql);
//$class_id = $returned['class_id'];
//$email = $_POST['email'];

if(isset($_SESSION['id']))
	$user_id = $_SESSION['id'];
else
{
	print "Yo. What are you doing man? Are you like even logged in? Jeez";
	exit;
}


function user_getUsername($id)
{ 
	$sql = 'SELECT user_name AS first FROM user '
			. " WHERE  status_id NOT IN (".STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_INACTIVE.','.STATUS_ALUMNI.','.STATUS_ADMINISTRATOR.','.STATUS_DEACTIVATED.") AND user_hidden = '0'  AND user_id = '$id'";
	
	$result = mysql_query($sql) or die("Query Failed!");
	
	$line = mysql_fetch_assoc($result);
	$uname = $line['first'];
	
	mysql_free_result($result);
	
	return $uname;
}



$codename = $_POST['codename'];
$realname = user_getUsername($user_id);
$num_kills = 0;
$alive = 1;
$current_target = NULL;



//SELECT * FROM `assassins2k16`
$sql = "select * from `assassinsf2k16` where user_id = '$user_id' ";
    $query = mysql_query($sql);
    if(mysql_num_rows($query)){
      //echo "<br> <center> <font  size = '5'> Yo man. You like signed up already. </font> </center> ";

    header("Location:/assassins/2k16/already_signed.php");
	exit(1);
    }



$sql = "INSERT INTO assassinsf2k16 (user_id, user_name, codename, num_kills, alive, current_target) VALUES ('$user_id', '$realname', '$codename', '$num_kills', '$alive','$current_target')";

mysql_query($sql) or die('Could Not Create Assassin.'.mysql_error());

header("Location:/assassins/2k16/done_signup.php");
?>


