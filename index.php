<?php
//アクセストークン
$ACCESS_TOKEN   = 'HlpevqaNfDeMOeHfBKr/5I2adUrmaP7KF5lhtIcV9h9fGKAvEbFfeQw+tvAUBCuX+LZS/DyVakdyG+2jzkl6yqe/4m85WYZoWIL9EVMSi1iS6iotUYdqpsS31bJrkCeyGEA0CyghpsI86M4KDlZj7wdB04t89/1O/w1cDnyilFU=';
$CHANNELID      = 1656594037;
$CHANNELSECRET  = 'dbebda3ae55c7b16741bae975d9e7493';
$WEBHOOKURL     = 'https://line-api-smp.exactly-good.work/index.php';
$REQUESTPOST    = 'https://api.line.me/v2/bot/message/reply';

$str = "LINE API";

$jsonsString = file_get_contents('php://input');    // apiから送られてくるwebhookを受け取る
error_log($jsonsString . "\n", 3, 'errors.log');           // とりあえずログにいれる

$jsonObj = json_decode($jsonString);                // jsonに変換
$messageData = $jsonObj->{"events"}[0]->{"message"};    // メッセージ関係のデータ
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};  // リプライトークン：返事に必要なトークン

// ひとまず返事をしてみる
$replyData = ['type' => 'text', 'text' => 'こんにちは！'];

$response = ['replyToken' => $replyToken, 'messages' => [$replyData]];
// ひとまずログに残す
error_log(json_encode($response) . "\n", 3, 'errors.log');

$requestPost = curl_init($REQUESTPOST);
curl_setopt($requestPost, CURLOPT_POST, true);
curl_setopt($requestPost, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($requestPost, CURLOPT_RETURNTRANSFER, true);
curl_setopt($requestPost, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($requestPost, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json; charser=UTF-8', 'Authorization: Bearer ' . $ACCESS_TOKEN ));
$result = curl_exec($requestPost);
error_log($result . "\n", 3, 'errors.log');
curl_close($requestPost);
?>
<h1><?php echo($str) ?></h1>
