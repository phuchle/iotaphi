<?php
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';

get_header();

$currentterm = db_currentClass('start');
?>

<h3 align="center">
    Congratulations.
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
    <form action="start.php">
        <input type="submit" value="Create Another Account">
    </form>
</div>

<?php show_footer(); ?>
