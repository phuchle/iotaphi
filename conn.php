<?php
//used for testing sql connection for Kevin 

$conn = mysqli_connect("db.iotaphi.org", "aphio", "icanhazdata?", "iotaphi");

if($conn)
{
	echo "Connection to DB Successful<br>";

}
else{

	echo "Connection to DB Not Sucessful<br>";
}
?>