<?php
$insta_client_id = 'chguyu_0916';
$insta_client_secret = 'asd0802e';
$insta_redirect_uri = 'http://example.com/redirect.php';
 
$authentication_url = "https://api.instagram.com/oauth/authorize?client_id=".$insta_client_id."&redirect_uri=".$insta_redirect_uri."&response_type=code";
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>
 <body>
 <a href="'.$authentication_url.'"> Click here to Authenticate</a>
 </body>
 </html>
