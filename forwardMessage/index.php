<?php
require_once('core.php');
require_once('db.php');

$content = file_get_contents("php://input");
$update = json_decode($content, true);
$chat_id = $update['message']['chat']['id'];
$text = $update['message']['text'];
$message_id = $update['message']['message_id'];

MessageRequestJson('forwardMessage',
    array(
    'chat_id' => CHAT_ID,
    'from_chat_id' => $chat_id,
    'message_id' => $message_id,
    )
);

