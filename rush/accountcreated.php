<?php
//Created by Stanton Ho 2/23/16, Nishiya-Milligan Term
    
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';

get_header();

$currentterm = db_currentClass('start');
?>

<h3 align="center">
    Congratulations, your Iota Phi account has been created!
</h3>
<br>
<div align="center">
    <p>
        Please log in by clicking the upper right button and fill out the information that will show up in the window. Thank You!
    </p>
    <hr>
    <h4>
        To create another account please click below.
    </h4>
    <form action="newuser.php">
        <input type="submit" value="Create Another Account">
    </form>
</div>

<?php show_footer(); ?>
