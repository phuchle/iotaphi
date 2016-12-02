<?php
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';

get_header();

if(isset($_SESSION['id']))
	$user_id = $_SESSION['id'];
else
{
	print "Yo. What are you doing man? Are you like even logged in? Jeez";
	exit;
}

$name = $_POST['name'];


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

$realname = user_getUsername($user_id);

if($name != $realname)
{
	echo " <center> DUDE. DO YOU EVEN KNOW YOUR OWN NAME. LMAO LOSER. </center>";
	echo "<p> <center> Your name is <b>$realname</b> (what an ugly name). Try again <a href='start.php'>here. </a> </center> </p>";
	exit;
}
else 
{

	//echo "<center> <font size='4' <b> OH SNAP! AYYYYY IT'S GONNA BE LIT. </b> </font> </center>";
	?>

<p> <br> </p>

<p></p>

<p></p>
	<center> <font size = "3"> Please Enter Your Desired Assassin Name. </font> <center>
		<p>This Is The Name That Other Players With Know You By. </p>

		<div align="center">
    <br />
    <form method="post" action="final_signup.php">
        <table>
            <tr>
                <td>
                    <label align="right">Assassin Name:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="text" name="codename" required>
                    <sub>(e.g. xXxBo0tyEat3rxXx)</sub>
                </td>
            </tr>
        </table>
    <br />
    <input type="submit" value="     Sign Up!     " align="center"/>
    </form>
</div>


<?php


}

?>