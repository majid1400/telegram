<?php
require_once('core.php');
require_once('db.php');

$content = file_get_contents("php://input");
$update = json_decode($content, true);
$chat_id = $update['message']['chat']['id'];
$text = $update['message']['text'];

//قسمت استارت
if ($text == '/start') {
    $matne = "به ربات شعر و جک خوش آمدید.";
}

// بخش منوی اصلی
elseif ($text == 'منوی اصلی'){
    $matne = 'گزینه ای را انتخاب کنید';
    $txt_keyboard = array(array('شعر', 'جوک', 'مشخصات'));
}

// بخش حک ها
elseif ($text == '/jok' or $text == 'جوک' or $text == 'جوک بعدی') {

    $db = Db::getInstance();
    $jok = $db->query("SELECT * FROM jok ORDER BY RAND() LIMIT 1");
    $matne = $jok[0]['text'];
    $matne .= "\n\n<a href=\"https://www.tarminet.com/\">سایت ما</a>";

    $txt_keyboard = array(array('منوی اصلی', 'جوک بعدی'));

}

// بخش شعرها
elseif ($text == '/sher' or $text == 'شعر' or $text == 'شعر بعدی') {

    $db = Db::getInstance();
    $sher = $db->query("SELECT * FROM sher ORDER BY RAND() LIMIT 1");
    $matne = $sher[0]['text'];
    $matne .= "\n\n<a href=\"https://www.tarminet.com/\">سایت ما</a>";

    $txt_keyboard = array(array('منوی اصلی', 'شعر بعدی'));

}

// بخش مشخصات
elseif ($text == 'مشخصات'){
    $matne = 'گزینه ای را انتخاب کنید';

    $txt_keyboard = array(
        array(
            array(text=>'شماره خود را وارد کنید: ',request_contact=>true),
            array(text=>'مکان خود را به اشتراک بگذارید: ',request_location=>true),
        ),
        array('منوی اصلی')
    );
}

// در صورت نبود هیچ یک از دستورات
else {
    $matne = 'دستور وارد شده صحیح نیست';
}



MessageRequestJson('sendMessage',
    array(
    'chat_id' => $chat_id,
    'text' => $matne,
    'parse_mode' => 'HTML',
    'reply_markup' => array(
        resize_keyboard => true,
        "keyboard" => $txt_keyboard,
    )
    )
);

