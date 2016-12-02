<?php
    
    include_once 'include/template.inc.php';
    include_once 'include/forms.inc.php';
    
    show_header();
    
    $currentterm = db_currentClass('start');
    
    ?>

<form method="post" action="input.php">
<div>
<fieldset>
<legend>New User</legend>
<label> Name: </td><td><input type="text" name="name" required></label>
<sub>(e.g. John Smith)</sub><br /><br />

<label> Address: </td><td><input type="text" name="address" required ></label>
<sub>(e.g. One Shields Avenue)</sub><br /><br />

<label> Phone Number: </td><td><input type="text" name="phone" pattern='\d{3}\d{3}\d{4}'/></label>
<sub>(e.g. 5556667777)</sub><br /><br />

<label> Email: </td><td><input type="text" name="email" required ></label>
<sub>(e.g. user@sample.com)</sub><br /><br />

<label> Snapchat: </td><td><input type="text" ></label>
<sub>( not required =] )</sub><br /><br />

<label> Password: </td><td><input type="password" name="password" required></label>
<sub>(Your password must be at least 8 characters in length)</sub><br /><br />

<label> Repeat Password: </td><td><input type="password" name="password2" required></label>
<input type="submit" />
</fieldset>
</div>
</form>

<?php show_footer(); ?>