<?php

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';

get_header();

$currentterm = db_currentClass('start');

?>

<h2 align="center">
    New User Signup Form
</h2>

<div align="center">
    <br />
    <form method="post" action="input.php">
        <table>
            <tr>
                <td>
                    <label align="right">Name:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="text" name="name" required>
                    <sub>(e.g. John Smith)</sub>
                </td>
            </tr>
            <tr>
                <td>
                    <label align="right">Phone Number:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="text" name="phone" pattern='\d{3}\d{3}\d{4}'/>
                    <sub>(e.g. 5556667777)</sub>
                </td>
            </tr>
            <tr>
                <td>
                    <label align="right">Email:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="text" name="email" required >
                    <sub>(e.g. user@sample.com)</sub>
                </td>
            </tr>
            <tr>
                <td>
                    <label align="right">Snapchat:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="text" >
                    <sub>( not required =] )</sub>
                </td>
            </tr>
            <tr>
                <td>
                    <label align="right">Password:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="password" name="password" required>
                    <sub>(Your password must be at least 8 characters in length)</sub>
                </td>
            </tr>
            <tr>
                <td>
                    <label align="right"> Repeat Password:</label>
                </td>
                <td>
                    &nbsp;
                    <input type="password" name="password2" required>
                </td>
            </tr>
        </table>
    <br />
    <input type="submit" value="     Submit     " align="center"/>
    </form>
</div>

<?php show_footer(); ?>
