<?php

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header();


function get_player_info($tempID)
{
	$sql = "SELECT * FROM assassins2k16 NATURAL JOIN user WHERE user_id='$tempID'";

	$result = mysql_query($sql) or die("Query Failed (get_player_info)! ". mysql_error());

	return mysql_fetch_assoc($result);
}


if(isset($_SESSION['id']))
	$user_id = $_SESSION['id'];
else
{
	print "You are not logged in.";
	show_footer();
	exit;
}


$class = $_SESSION['class'];

if(isset($_GET['user']))
	$user_id = (int)$_GET['user'];

if ( $user_id <= 0 )
{
	print "That person doesn't exist.";
	show_footer();
	exit;
}
$sql = 'SELECT user_name, family_name, class_nick, user_address, text_type,'
        . ' user_phone, user_cell, user_email, user_snapchat, user_password , major'
        . ' FROM user, class, text, family'
		. " WHERE user_id = '$user_id' "
		. ' AND user.class_id = class.class_id '
        .  ' AND user.family_id = family.family_id'
        .  ' AND user.text_id = text.text_id' ;
$line = db_select1($sql);
if ( !is_array( $line ) )
{
	print "That person doesn't exist.";
	show_footer();
	exit;
}

extract($line);

$user_phone = show_phone($user_phone);
$user_cell = show_phone($user_cell);


$is_playing = get_player_info($user_id);



?>

<table class="table table-condensed table-bordered">
	<tr>
		<td colspan="3" class="heading"><?php echo $user_name ?></td>
	</tr>
	<tr>
		<td rowspan="10"><img src="/images/profiles/<?php echo $user_id ?>.jpg" /></td>
		<td>Address: </td>
		<td><?php echo htmlentities($user_address) ?></td>
	</tr>
	<tr>
		<td>Primary Phone: </td>
		<td><?php echo htmlentities($user_cell) ?></td>
	</tr>
	<tr>
		<td>Text Type: </td>
		<td><?php echo $text_type ?></td>
	</tr>
	<tr>
		<td>Email: </td>
		<td><a href="mailto:<?php echo htmlentities($user_email) ?>"><?php echo htmlentities($user_email) ?></a></td>
	</tr>
	<tr>
		<td>Snapchat: </td>
		<td>

			<?php // if user snapchat is not blank, show snapchat photo and sc name

				if($user_snapchat == 'timetoeatdinher')
				{
					?> <img src="/images/fatkid.jpg"> <?php echo htmlentities($user_snapchat) ?> <?php;
					echo "<audio autoplay>";
					echo "<source src=\"numanuma.mp3\" type=\"audio/mpeg\">";
					echo "</audio>";
				}

				else if ( $user_snapchat != " " )
				{
   					?> <img src="/images/snapchat.jpg"> <?php echo htmlentities($user_snapchat) ?> <?php;
				}
				?>

		</a></td>

	</tr>

	<!-- <tr>
		<td>Family: </td>
		<td><?php echo $family_name ?></td>
	</tr> -->
	<tr>
		<td>Class: </td>
		<td>
			<?php if($user_id == 3281)
						echo 'CHE 2A';

			    else echo $class_nick ?>
		</td>
	</tr>
	<tr>
		<td>Service Badge:<br>(Awarded for Doubling Required Hours)</td>
		<td><?php
//===========================================================================================================================================================
/* Added by Justin Quizon 05/04/13
*Documentation will be available shortly
*/
		$classquery = "SELECT class_id FROM user WHERE user.user_id = '$user_id'";
			$returnedclass = db_select1($classquery);
			$class_id =  $returnedclass['class_id'];
			if($class_id < 100){
			   echo 'Badge information unavailable';
			}
			else{
			   $badgequery = 'SELECT min_Hours,class_nick,'
			 			. " DATE_FORMAT(badges.term_start, '%Y%m%d%h%i%s') as term_start,"
						. " DATE_FORMAT(badges.term_end, '%Y%m%d%h%i%s') as term_end, badge_id"
						. ' FROM `badges` '
						. " WHERE badges.class_id >= '$class_id'";

			   $returnedpossiblebadges = db_select($badgequery);
			   $i = 0;
			   $currentterm = db_currentClass('start');
			   foreach($returnedpossiblebadges as &$badge){
			    $start = $badge['term_start'];
			    $end = $badge['term_end'];
			    if($badge['term_start'] != $currentterm){
				$hoursquery = 'SELECT user_name AS name,'
			  				. ' sum(tracking.hours) AS hours '
			  				. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event '
			  				. ' WHERE event.event_id = tracking.event_id '
                          				. " AND event_date > '$start'"
                          				. " AND event_date < '$end' "
			  				. ' AND eventtype_id = 1 '
			  				. " AND user.user_id = '$user_id'";
				$hours = db_select1($hoursquery);
				if($hours['hours'] >= $badge['min_Hours']){
				   echo $badge['class_nick']; $i++;
				   echo '<img src="/images/profiles/badge.png" />'."<br>";}
			     }
			    else{
				$hoursquery = 'SELECT user_name AS name,'
			  				. ' sum(tracking.hours) AS hours '
			  				. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event '
			  				. ' WHERE event.event_id = tracking.event_id '
                          				. " AND event_date > '$start'"
			  				. ' AND eventtype_id = 1 '
			  				. " AND user.user_id = '$user_id'";
				$hours = db_select1($hoursquery);
				if($hours['hours'] >= $badge['min_Hours']){
				   echo $badge['class_nick']; $i++;
				   echo '<img src="/images/profiles/badge.png" />'."<br>";}
			    }
			   }
			   unset($badge);
			   if( $i == 0 && $user_id != 3281 && $user_id != 2834)
				echo 'No Badges Obtained';
			}
//=======================================================================================================================================
		?></td>
	</tr>
	<tr>
		<td>Fellowship Badge:<br>(Awarded for Doubling Required Events)</td>
		<td><?php
//===========================================================================================================================================================
/* Added by Justin Quizon 05/04/13
*Documentation will be available shortly
*/
		$classquery = "SELECT class_id FROM user WHERE user.user_id = '$user_id'";
			$returnedclass = db_select1($classquery);
			$class_id =  $returnedclass['class_id'];
			if($class_id < 100){
			   echo 'Badge information unavailable';
			}
			else{
			   $badgequery = 'SELECT min_Fellowships,class_nick,'
			 			. " DATE_FORMAT(badges.term_start, '%Y%m%d%h%i%s') as term_start,"
						. " DATE_FORMAT(badges.term_end, '%Y%m%d%h%i%s') as term_end, badge_id"
						. ' FROM `badges` '
						. " WHERE badges.class_id >= '$class_id'";

			   $returnedpossiblebadges = db_select($badgequery);
			   $i = 0;
			   $currentterm = db_currentClass('start');
			   foreach($returnedpossiblebadges as &$badge){
			    $start = $badge['term_start'];
			    $end = $badge['term_end'];
			    if($badge['term_start'] != $currentterm){
				$eventsquery = 'SELECT user_name AS name,'
			  				. ' count(user.user_id) AS events '
			  				. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event '
			  				. ' WHERE event.event_id = tracking.event_id '
                          				. " AND event_date > '$start'"
                          				. " AND event_date < '$end' "
			  				. ' AND eventtype_id = 2 '
			  				. " AND user.user_id = '$user_id'";
				$events = db_select1($eventsquery);
				if($events['events'] >= $badge['min_Fellowships']){
				   echo $badge['class_nick']; $i++;
				   echo '<img src="/images/profiles/badge.png" />'."<br>";}
			     }
			    else{
				$eventsquery = 'SELECT user_name AS name,'
			  				. ' count(user.user_id) AS events '
			  				. ' FROM (user NATURAL JOIN class) NATURAL JOIN tracking, event '
			  				. ' WHERE event.event_id = tracking.event_id '
                          				. " AND event_date > '$start'"
			  				. ' AND eventtype_id = 2 '
			  				. " AND user.user_id = '$user_id'";
				$events = db_select1($eventsquery);
				if($events['events'] >= $badge['min_Fellowships']){
				   echo $badge['class_nick']; $i++;
				   echo '<img src="/images/profiles/badge.png" />'."<br>";}
			    }
			   }
			   unset($badge);
			   if( $i == 0 && $user_id != 3281 )
				echo 'No Badges Obtained';
			}
//=======================================================================================================================================
		?></td>
	</tr>
	<tr>
		<td>Miscellaneous Badges:</td>
		<td><?php
			if(isset($is_playing['user_id'])==1)
			{
				?> Assassins S2K16 Participant &nbsp;<img src="/people/ass2.gif" width="20" height="20"><br><?php
			}
			if($user_id == 3281)
			{
				echo 'Thirstiest Pledge F2K15';
					echo "<audio autoplay>";
					echo "<source src=\"baby.mp3\" type=\"audio/mpeg\">";
					echo "</audio>"; ?> <img src="/images/thirsty.jpeg"> <br><?php

			}
			if($user_id == 2834)
			{
				echo 'First to Complete 1 Billion Gallzillion Service Hours'; ?> <img src="win.gif" style="width:304px;height:228px;" ><br> <?php

			}
			if($user_id == 3281)
			{
				echo 'EDC 2016' ?> <img src="/images/dason.jpg"> <br> <?php;

			}
		?></td>
	</tr>

	<tr>
		<td>Major: </td>
		<td><?php echo $major ?></td>
	</tr>
</table>

<?php show_footer(); ?>
