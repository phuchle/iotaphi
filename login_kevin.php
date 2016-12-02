<?php

//used for testing SQL db connection - Kevin

require "conn.php";


//$user_name = "test_kevin";
//$user_pass = "12345678";
$user_name = $_POST["user_name"];
$user_pass = $_POST["password"];
$mysql = "SELECT user_id FROM `user` WHERE user_name = '$user_name' AND user_password = '$user_pass'";
//$result = mysqli_query($conn, $mysql) or die("Query Failed!". mysql_error()); 

$result = mysqli_query($conn, $mysql);

if(mysqli_num_rows($result) > 0)
{
	echo "<br>Login Success!";
}
else
{
	echo "<br>Login Not Successful :(";
}


?>