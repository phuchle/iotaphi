<?php

include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';

get_header();

$currentterm = db_currentClass('start');
?>

<h3 align="center">
    Congrats. You Successfully Signed Up.  
</h3>
<div align="center">
    <p>  
        <center> <img src="ready.jpg"> </center>


        <h4> Ayyyyyy. Assassins Gonna Be Lit. May the Odds Ever Be in Your Favor </h4>
    </p>
    <hr>
    <h4>
       <!-- <a href = "home.php">Click here for Your Mission Info. </a>!-->
        
        <a href = "all_players.php"> Click here for List of Current Players </a>
        <br>
    </h4>
</div>

<?php show_footer(); ?>
