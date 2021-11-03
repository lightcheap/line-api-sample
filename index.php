<?php
//アクセストークン
$ACCESS_TOKEN   = 'HlpevqaNfDeMOeHfBKr/5I2adUrmaP7KF5lhtIcV9h9fGKAvEbFfeQw+tvAUBCuX+LZS/DyVakdyG+2jzkl6yqe/4m85WYZoWIL9EVMSi1iS6iotUYdqpsS31bJrkCeyGEA0CyghpsI86M4KDlZj7wdB04t89/1O/w1cDnyilFU=';
$CHANNELID      = 1656594037;
$CHANNELSECRET  = 'dbebda3ae55c7b16741bae975d9e7493';
$WEBHOOKURL     = 'https://line-api-smp.exactly-good.work/index.php';
$REQUESTPOST    = 'https://api.line.me/v2/bot/message/reply';


$jsonString = file_get_contents('php://input');    // apiから送られてくるwebhookを受け取る
error_log("post:" . $jsonString . "\n", 3, 'errors.log');           // とりあえずログにいれる

$jsonObj = json_decode($jsonString);                // オブジェクトに変換

$receivingMessage = $jsonObj->events[0]->message->text;
$replyToken  = $jsonObj->events[0]->replyToken;
error_log("message-data:" . $receivingMessage . "\n", 3, 'errors.log');
error_log("reply-token:" . $replyToken . "\n", 3, 'errors.log');

// 送られてきたメッセージからレスのタイプを分ける
if ($receivingMessage == "確認") {
    // 確認ダイアログタイプ
    $replyData = [
        'type' => 'template',
        'altText' => '確認のダイアログ',
        'template' => [
            'type' => 'confirm',
            'text' => '確認ダイアログです',
            'actions' => [
                // 確認ダイアログのactionsは２つ以上は出来ないっぽい
                ['type' => 'message', 'label' => 'ボタン', 'text' => 'ボタン'],
                ['type' => 'message', 'label' => 'カルーセル', 'text' => 'カルーセル'],
                // ['type' => 'message', 'label' => 'ボタン', 'text' => 'ボタン']
            ]
        ]
    ];

} elseif ($receivingMessage == "ボタン") {
    // ボタンタイプ
    $replyData = [
        'type' => 'template',
        'altText' => 'ボタン',
        'template' => [
            'type' => 'buttons',
            'title' => 'ボタンタイプです',
            'text' => '選択してね',
            'actions' => [
                [
                    'type' => 'postback',
                    'label' => 'webhookにpost送信',
                    'data' => 'value'
                ],
                [
                    'type' => 'uri',
                    'label' => 'googleへ移動',
                    'uri' => 'https://google.com'
                ]
            ]
        ]
    ];
} elseif ($receivingMessage == 'カルーセル') {
    // カルーセル
    $replyData = [
        'type' => 'template',
        'altText' => 'カルーセルタイプ',
        'template' => [
            'type' => 'carousel',
            'columns' => [
                [
                    'title' => 'カルーセル1',
                    'text' => 'カルーセル1です',
                    'actions' => [
                        [
                            'type'  => 'postback',
                            'label' => '確認',
                            'data'  => "確認"
                        ],
                        [
                            'type'  => 'uri',
                            'label' => 'はてな',
                            'uri'   => 'https://b.hatena.ne.jp/hotentry/all'
                        ]
                    ]
                ],
                [
                    'title' => 'カルーセル2',
                    'text' => 'カルーセル2です',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhookにpost送信',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => 'teratail',
                            'uri' => 'https://teratail.com/'
                        ]
                    ]
                ],
                [
                    'title' => 'カルーセル3',
                    'text' => 'カルーセル３です',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhookにpost送信',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => 'teratail',
                            'uri' => 'https://teratail.com/'
                        ]
                    ]
                ],
            ]
        ]
    ];
} else {
    // 上記以外はオウム返し
    $replyData = ['type' => 'text', 'text' => $receivingMessage];
}

$response  = ['replyToken' => $replyToken, 'messages' => [$replyData]];
error_log("res:" . json_encode($response) . "\n", 3, 'errors.log');

// ↓はメッセージ送信の一定の処理
$requestPost = curl_init($REQUESTPOST);
curl_setopt($requestPost, CURLOPT_POST, true);
curl_setopt($requestPost, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($requestPost, CURLOPT_RETURNTRANSFER, true);
curl_setopt($requestPost, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($requestPost, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $ACCESS_TOKEN ));
$result = curl_exec($requestPost);
error_log("result:" . $result . "\n", 3, 'errors.log');
curl_close($requestPost);

