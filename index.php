<?php
//アクセストークン
$ACCESS_TOKEN   = 'HlpevqaNfDeMOeHfBKr/5I2adUrmaP7KF5lhtIcV9h9fGKAvEbFfeQw+tvAUBCuX+LZS/DyVakdyG+2jzkl6yqe/4m85WYZoWIL9EVMSi1iS6iotUYdqpsS31bJrkCeyGEA0CyghpsI86M4KDlZj7wdB04t89/1O/w1cDnyilFU=';
$CHANNELID      = 1656594037;
$CHANNELSECRET  = 'dbebda3ae55c7b16741bae975d9e7493';
$WEBHOOKURL     = 'https://line-api-smp.exactly-good.work/index.php';


$jsonsString = file_get_contents('php://input');
$jsonObj = json_decode($jsonString);
// var_dump($jsonObj);
$str = "hello";
?>
<h1><?php echo($str) ?></h1>
<p><?php echo($jsonsString) ?></p>
