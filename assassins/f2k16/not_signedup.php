<?php

include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';

get_header();

$currentterm = db_currentClass('start');
?>

<h3 align="center">
   Hey Loser. What are you doing. You're Not Even Signed Up to Play... 
</h3>
<div align="center">
    <p> 
        <center> <img src="not_ready.jpg"> </center>


        <h4> Come Thru Doe Cuh. It Lit Mang </h4>
    </p>
    <hr>
    <h4>
        <a href = "start.php">Click here to Sign Up. </a>
        <br>
        <br>
    </h4>
</div>

<?php show_footer(); ?>
