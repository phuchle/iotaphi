<?php

include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';

get_header();

$currentterm = db_currentClass('start');
?>

<h3 align="center">
    Yo Man. You like already Signed-Up. 
</h3>
<div align="center">
    <p> 
        <center> <img src="blackmeme.jpg"> </center>


        <h4> Stop Trying So Hard. Game Hasn't Even Started Yet... </h4>
    </p>
    <hr>
    <h4>
       <!-- <a href = "home.php">Click here for Your Mission Info. </a>-->
        <br>
        <br>
        <a href = "all_players.php"> Click here for List of Current Players </a>
    </h4>
</div>

<?php show_footer(); ?>
