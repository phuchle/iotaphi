<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header();

echo "<div class=\"general\">\n";

if(isset($_GET['name'])){
    $name = $_GET['name'];
	if($name == 'failure')
	{
		echo 'Sorry, the email address you entered was not recognized and no mail was sent.<br />';
	}
	else
	{
		echo "Thank you $name! Check your email in a few minutes to get your login information!</div>";
		show_footer();
		exit();
	}
}
?>

<br /><br />

<span>
Enter your email address to reset your password.
</span>



<br /><br />
<form method="POST" action="/forgetful/input.php">
<?php forms_hiddenInput('mailpassword','');
forms_text(30,'email','');
forms_submit('Send me my password!');
?></form>
<br />
<span>If you get an error or do not receive an email within an hour, contact <a href="mailto:webmaster@iotaphi.org">webmasters</a>.</span>

</div><?php

show_footer();
?>
