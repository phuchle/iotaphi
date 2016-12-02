<?php

set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

define('clientID', 'bcaa60ba9f2643c0bd9ce7de1a70f48f');
define('clientSecret', '1ac6f50758c741459da8d127173f7686');
define('instagramAT', 'https://api.instagram.com/oauth/access_token');
define('redirectURI', 'http://www.iotaphi.org/iphilfs/index.php');

///funtion to connect to Instagram
function connectToInstagram($url)
{
  $ch = curl_init();

    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => 2,
      ));
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}




function instagramAPI($url){
 $ch = curl_init();

 curl_setopt_array($ch, array(
   CURLOPT_URL => $url,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_SSL_VERIFYHOST => 2
  ));

 $result = curl_exec($ch);
 curl_close($ch);

 return $result;
}

//funcion to get userID for pics
function getUserID($userName)
{
  $url = 'http://api.instagram.com/v1/users/search?q='.$userName.'&client_id='.clientID;
  $instagramInfo = connectToInstagram($url);
  $results = json_decode($instagramInfo, true);

  echo here;

  echo $results['data']['0']['id'];
}

function printImages($userID)
{
  $url = 'https://api.instram.com/v1/users/'.$userID.'/media/recent?client_id='.clientID.'&count=5';
  $instagramInfo = connectToInstagram($url);
  $results = json_decode($instagramInfo, true);
  //foreach($results['data'] as $items)
  //{
    //$image_url = $items['images']['low_resolution']['url'];
    //echo '<img src=" '.$image_url.' "/><br/>';
 // }

}


if(isset($_GET['code'])){
   $access_token_settings = array('client_id' => clientID,
      'client_secret' => clientSecret,
      'grant_type' => 'authorization_code',
      'redirect_uri' => redirectURI,
      'code' => $_GET['code']
  );

 $curl = curl_init(instagramAT);
 curl_setopt($curl, CURLOPT_POST, true);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

 $result = curl_exec($curl);
 curl_close($curl);

 $results = json_decode($result, true);

 $userName = $results['user']['username'];

 echo $userName;

 $userID = getUserID($userName);

 printImages($userID);

}

else{
?>
<!doctype html>
<html>
<head>
 <title></title>
</head>
<body>
 <a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN</a>
</body>
</html>﻿
<?php } ?>