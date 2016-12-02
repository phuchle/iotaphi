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


function get_player_info($tempID)
{
	$sql = "SELECT * FROM assassinsf2k16 NATURAL JOIN user WHERE user_id='$tempID'";
			
	$result = mysql_query($sql) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result);
}


function get_numb_alive()
{
	$sql = "SELECT * FROM assassinsf2k16 WHERE user_id='$tempID'";
			
	$result = mysql_query($sql) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result);
}


function get_num_death($tempID)
{
	$sql = "SELECT * FROM assassinsf2k16 NATURAL JOIN user WHERE user_id='$tempID'";
			
	$result = mysql_query($sql) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result);
}


function total_alive($tempID)
{
	$sql2 = "SELECT * FROM assassinsf2k16 WHERE alive = 1";

	$result2 = mysql_num_rows($sql2) or die("Query Failed (get_player_info)! ". mysql_error());

	return $result2;
}

function total_no_kills()
{
  $sql = "SELECT * FROM `assassinsf2k16` WHERE `num_kills` = 0 AND `alive` = 1";
  $result = mysql_query($sql) or die("Query Failed (get_player_info)! ". mysql_error());
  
  return $result;

}

$blah = total_no_kills();
$num_0_count = 0;
while( $row=mysql_fetch_row($blah) )
{ 
  $num_0_count = $num_0_count +1;
}//while


//$total_alive = total_alive($user_id);

//echo "$total_alive"; 

$name = 3347;

$myInfo = get_player_info($myID);
$aliveInfo = get_player_info($name);

//if not signed up for assassins
if(isset($myInfo['user_id'])==0)
{
	header("Location:/assassins/f2k16/not_signedup.php");
	exit(1);
}



$end_sunday = strtotime("November 27, 2016 11:59 PM");
$remaining2 = $end_sunday - time();


$days_remaining2 = floor($remaining2 / 86400);
$hours_remaining2 = floor(($remaining2 % 86400) / 3600);
$min2 = floor(($remaining2 % 3600) / 60);
$sec2 = ($remaining2 % 60);



$date = strtotime("November 30, 2016 11:59 PM");
$remaining = $date - time();

$days_remaining = floor($remaining / 86400);
$hours_remaining = floor(($remaining % 86400) / 3600); 
$min = floor(($remaining % 3600) / 60);
$sec = ($remaining % 60);

$left = 65 - $aliveInfo['alive'];

//echo "$left";
?>


<center> 
<?php 

if($myInfo['num_kills'] == 0)
{
?>
  <b><big> U HAVE 0 KILLS WYD ???</big></b> <br>
 <big> KILL SOMEONE BY 11/20 OR GET RECKT </big><br>

  <br>
    <iframe src="//giphy.com/embed/gpufDFw0sPBYY" width="480" height="202" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
    <br><br><br>
  </center>
  <?php 
}



if($myInfo['num_kills'] == 1)
{
  ?> 
  <center><big> YO LOSER. It Looks Like You Have Less Than <font color = "red"> Two </font> Kills Right Now. <br> What are you even doing with your life man...
<br> Hurry Up and Get A Kill Cause in <b> <?php echo $days_remaining2 ?> </b> days and <b><?php echo $hours_remaining2 ?></b> hours, you're gonna be put on everyone's kill list.<br>
  </center>

  <iframe src="//giphy.com/embed/d3Kq6BBvvUmA1ifu?html5=true" width="480" height="200" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
  <br><br> SO PLEASE GET A KILL and don't let me, don't let me, don't let me down, D-don't let me down<br><br>
<?php
}
?>
</center>







<p><center><font size = "5"> Welcome to Assassins, <b> <?php echo $myInfo['user_name']; ?> </b>! </font></center></p>
<center> <font size ="4"> or should I call you <b><?php echo $myInfo['codename'];?> </b> </font>
<br><br>
<center> <img src='http://www.iotaphi.org/images/profiles/<?php echo $myInfo['user_id'];?>.jpg'> </center>
<br> <br><br> 
<br> <big> People You Killed: <font color = "red"> <?php echo $myInfo['num_kills'] ?>  </big> </font>
<br> <big> Deadliest Assassin: 

<font color = "red">

<?php 

$rank = 0;
$sql_total = "SELECT codename, num_kills, alive FROM assassinsf2k16 ORDER BY num_kills DESC, alive DESC, codename ASC LIMIT 1";
$result_total = mysql_query($sql_total) or die(mysql_error());

$index = 0;
while($line = mysql_fetch_assoc($result_total)) {
  if ($line['alive'])
    $names[$index] = $line['codename'];
  else $names[$index] = $line['codename']." (Dead)";
  $kills[$index] = $line['numkills'];
  $index++;


  echo $line['codename'];

}
mysql_free_result($result_total);

?>



</font></big>







<br> <big> Latest Killed: <font color = "red"> <?php echo $aliveInfo['killcode'] ?> </big> </font>  </big>
<br> <big> Total Deaths: <font color = "red"> <?php echo $aliveInfo['alive'] ?> </big> </font>
<br> <big> Total Alive Assassins : <font color = "red">  <? echo $left ?> </big> </font>
<br> <big> Time Remaining: <font color = "red"> <?php echo "$days_remaining days, $hours_remaining hours, $min mins, $sec secs"; ?> </big> </font>

<br>
<br>


<br> 
<a href = "view_target.php"> Click Here To View Your Current Target </a>
<br> 
<br>
<a href = "confirm_kill.php"> Click Here To Confirm Your Kill</a>
<br>
<br>
<a href = "self_defense.php"> Click Here If You Killed Your Killer in Self Defense</a>
<br>
<br> 
<a href = "view_killcode.php"> Click here to view Your Kill Code (KEEP A SECRET) </a>
<br>
<br> 
<a href="all_players.php">Click Here To View The Players.</a>
<br>
<br>
<a href="view_fallen.php">Click Here To Pay Your Respects.</a>
<br>
<br>
<!--<a href="the_final_17.php">The Final Survivors</a>
<br>--> 
<a href= "halloffame.php"> Click Here to see the HALL OF FAME </a>
<br>
<br>

<a href="view_rules.php"> Click Here to View the Rules </a>
<br>



<!-- 
<center><b>

  YOUR VOTES ARE FINALLY IN!</b>
  <br>
  <br>
  Most Badass Weapon: <a href="http://www.iotaphi.org/people/profile.php?user=2936"> Pal3xXA55xXm0f0 </a>
  <br>
  Most Try-Hard Weapon: <a href="http://www.iotaphi.org/people/profile.php?user=3316"> Fat Princess </a>
  <br>
  Best Assassin Name: <a href="http://www.iotaphi.org/people/profile.php?user=3269"> Sara Rehimi </a>
  <br>
  Worst Assassin Name: <a href="http://www.iotaphi.org/people/profile.php?user=3239"> kevin dinh eats ass </a>
  <br>
  "Who Are You Again?" Assassin: <a href="http://www.iotaphi.org/people/profile.php?user=2667"> goodlucklel </a>
  <br>
  Sneakiest Ninja: <a href="http://www.iotaphi.org/people/profile.php?user=3013"> yuna </a>
  Sneakiest Ninja:  <a href="http://www.iotaphi.org/people/profile.php?user=0"> 
      &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;</a>
  <br>
  Least Sneakiest Assassin: <a href="http://www.iotaphi.org/people/profile.php?user=3258"> Poptart </a>
  <br>
  Creepiest Assassin: <a href="http://www.iotaphi.org/people/profile.php?user=3267"> EatTheBootyLikeGroceries
 </a>
  <br>
  Most Savage Assasin: <a href="http://www.iotaphi.org/people/profile.php?user=2835"> C60 </a>
  <br>
  Most Hidden Assassin: <a href="http://www.iotaphi.org/people/profile.php?user=3147"> x3boobear </a>
  <br>
  Assassin Who Touches The Most Little Boys: <a href="http://www.iotaphi.org/people/profile.php?user=3245"> zzzzaazaazaz</a>
  <br>
  Most Suprised Death: <a href="http://www.iotaphi.org/people/profile.php?user=2884"> á¶˜ áµ’á´¥áµ’á¶ </a>
  <br>
  Participation Point: <a href="http://www.iotaphi.org/people/profile.php?user=3382"> DexlessSin </a>
  <br>

<br>

 <b> THANK YOU ALL FOR VOTING AND GOOD LUCK TO <a href= "the_final_17.php">THE FINAL 17</a></b>
</center>
!-->

<br>
<br>
<br> 

<br>
<center><big> <b>General Announcements</b></big></center><br>
<center> None.... for now :^) </center>
<!--
<center><big> <b> 1. </b> Constantly Check Your MAIN Target. The system may randomly reassign you a new MAIN Target due to a recent conflicting Death.<br></big>
<br></font> <big> <b> 2.</b> There are currently <b> <?php echo $num_0_count?> </b> Assassins Left With 0 Kills.  </big>
 <br><big> <br> <b>3.</b> <font color = "red"> <b> There are no more safe zones. </b><br> </font></big>
<big> <br> <b>4. Dead Assassins Can Now Kill Assassins With Less Than 1 Kill. </b> <br> </big>
  </center>!-->


<br>
<br>


<br>
<center><big> <b>Death Scenes</b></big></center>
<br>

<head>


  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script>
    google.charts.load('current', { 'packages': ['map'] });
    google.charts.setOnLoadCallback(drawMap);

    function drawMap() {
      var data = google.visualization.arrayToDataTable([
       ['Lat', 'Long', 'Name'],
       [38.539007,-121.751852,'Student Community Center'],
       [38.5385296,-121.7518772, 'Peter A. Rock Hall'],
       [38.539286, -121.753121, "W Line"],
       [38.539631, -121.755772, "Sci Lab"],
       [38.542644, -121.759076, "ARC Pavillion"],
      /* [38.541714, -121.749506, 'MU Flag Pole'],
       [38.538484, -121.755634, 'Surge III'],
       [38.539834, -121.747596, 'Olson Hall'],
       [38.539682, -121.721746, 'Dapson House'],
       [38.539799, -121.749762, 'Shields Library'],
       [38.539581, -121.749700, 'Shields Library'],
       [38.542733, -121.749775, 'Freeborn Hall'],
       [38.535983, -121.757267, "Trudy's, Tercero"],
       [38.539880, -121.752267, "Harring Hall"],//1 
       [38.539804, -121.752739, "Harring Hall"],//2
       [38.558646, -121.743292, "Big Dong"],//3
       [38.544339, -121.749814, "MU Parking Structure"],//4
       [38.539373, -121.749545, "Shields Library"],//5 maybe?
       [38.539665, -121.753894, "Harring Hall"],//6
       [38.536701, -121.756498, "Scrub Oak, Tercero"],
       [38.539594, -121.754005, "Harring Hall"],
       [38.546694, -121.763250, "Webster Hall"],
       [38.537716, -121.755225, "Giedt Hall"],
       [38.539744, -121.753064, "Harring Hall"],
       [38.539725, -121.721550, "Scrub's House"],
       [38.539738, -121.721786, " 'So they weren't here for paint'"],
       [38.538551, -121.724935, "King's Landing"],
       
       [38.543742, -121.749946, "K Line"],
       [38.540864, -121.754542, "Storer Hall"],
       [38.536725, -121.751276, "Physics Building"],
       [38.540288, -121.732038, "4 Seasons"],
       [38.564196, -121.766239, "Temescal Apartments"],
       [38.534647, -121.758271, "Potter Hall, Tercero"]

*/
      	]);



    var options = {
        mapType: 'styledMap',
        zoomLevel: 13,
        showTip: true,
        useMapTypeControl: true,
        //mapTypeId: google.maps.MapTypeId.ROADMAP

        maps: {
          // Your custom mapTypeId holding custom map styles.
          styledMap: {
            name: 'Styled Map', // This name will be displayed in the map type control.
            styles: [
              {featureType: 'poi.attraction',
               stylers: [{color: '#fce8b2'}]
              },
              {featureType: 'road.highway',
               stylers: [{hue: '#0277bd'}, {saturation: -100}]
              },
              {featureType: 'road.highway',
               elementType: 'labels.icon',
               stylers: [{hue: '#000'}, {saturation: 100}, {lightness: 0}]
              }
        ]}}
      };  

    //var options = { showTip: true };

    var map = new google.visualization.Map(document.getElementById('chart_div'));





    map.draw(data, options);
  };
  </script>
  </head>
  <body>
    <div id="chart_div"></div>
  </body>

<br>
<br>

<center> <big><b>Nightly Announcement</b></big> 
  <br>
  <br>
  <big> Coming soon ! <big>
<!--
<video  controls>
  <source src="5192016.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
!-->
</center>


<br>

<br>
<center>
<br> 

<!--If You Are Confused About Your Target Or Find Any Bugs, Please FB Message <a href="http://www.iotaphi.org/people/profile.php?user=3347">Beatrice Zhu</a>, <a href="http://www.iotaphi.org/people/profile.php?user=3360">Robert Tucker</a>, and <a href="http://www.iotaphi.org/people/profile.php?user=3341"> Carlo Maskarino</a>.-->

If You Are Confused About Your Target Or Find Any Bugs, Please FB Message<br> <b> Beatrice Zhu</b>, <b> Robert Tucker</b>  and <b> Carlo Maskarino</b> . 


</center>
<br>
<br>
<br>


<?php show_footer(); ?>

