<?php
$url     = "http://101.230.1.166/php/login.php";
$ref     = "http://101.230.1.166/";
$session = "PHPSESSID=abcdef01234567890abcdef01";
 
$ch      = curl_init();

$statement = "username=t234&password=t234";
 
curl_setopt( $ch, CURLOPT_URL,            $url     );
curl_setopt( $ch, CURLOPT_REFERER,        $ref     );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE     );
curl_setopt( $ch, CURLOPT_COOKIE,         $session );
curl_setopt( $ch, CURLOPT_POST,           TRUE     );
curl_setopt( $ch, CURLOPT_POSTFIELDS,    $statement);

echo $statement."<br />";

$data = curl_exec( $ch );
 
print( $data );
curl_close( $ch );
?>
