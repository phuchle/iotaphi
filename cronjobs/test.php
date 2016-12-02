<?php
	$path = '/iotaphi/iotaphi.org/include';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);

	$email = 'kevin.dinh50@yahoo.com';
	$subject = 'Test Email';
    $message = 'Hellos! Here, have a <a href="www.google.com">link</a>!';
    $headers  = 'From: The IotaPhi Robot <admin@iotaphi.org>' . "\n";
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";

    mail($email, $subject, $message, $headers);
	echo "Sent email!\n";
	//echo ini_set('doc_root', '/home/iotaphi/iotaphi.org/include');
	//echo get_cfg_var('cfg_file_path');
	//echo get_include_path();
	//print_r($_SERVER);
?>