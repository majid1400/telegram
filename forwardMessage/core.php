<?php
//1- sethook = https://api.telegram.org/bot<token>/setWebhook?url=<address>
define('BOT_TOKEN', '****');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');
define('CHAT_ID', '****');

function MessageRequestJson($method, $parameters)
{
    if (!$parameters) {
        $parameters = array();
    }

    $parameters["method"] = $method;

    $handle = curl_init(API_URL);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
    curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $result = curl_exec($handle);
    return $result;
}