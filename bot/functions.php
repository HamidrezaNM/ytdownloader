<?php

global $token;
$token = 'YOUR_TOKEN';
global $url;
$url = 'https://api.telegram.org/bot' . $token;

function request($request, $params)
{
    $url = $GLOBALS['url'];

    $ch = curl_init($url . $request);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function deleteMessage($chat_id, $message_id)
{
    $params = [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
    ];

    request('/deleteMessage', $params);
}

function sendMessage($chat_id, $text)
{
    $params = [
        'chat_id' => $chat_id,
        'text' => $text,
				"parse_mode" => "Markdown",
    ];

    return json_decode(request('/sendMessage', $params))->result->message_id;
}

function sendMessageWithKeyboard($chat_id, $text, $keyboard, $reply = null)
{
    $params = [
        'chat_id' => $chat_id,
        'text' => $text,
				'reply_to_message_id' => $reply,
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard,
    ];

    return json_decode(request('/sendMessage', $params));
}

function sendPhoto($chat_id, $photo)
{
    $params = [
        'chat_id' => $chat_id,
        'photo' => $photo,
    ];

    return json_decode(request('/sendPhoto', $params));
}


function sendPhotoMessageWithKeyboard($chat_id, $photo, $text, $keyboard)
{
    $params = [
        'chat_id' => $chat_id,
				'photo' => $photo,
        'caption' => $text,
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard,
    ];

    return json_decode(request('/sendPhoto', $params));
}

function editMessageText($chat_id, $message_id, $text)
{
    $params = [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $text,
				"parse_mode" => "Markdown",
    ];

    echo request('/editMessageText', $params);
}

function sendAudio($chat_id, $audio)
{
    $params = [
        'chat_id' => $chat_id,
        'audio' => $audio,
    ];

    return json_decode(request('/sendAudio', $params));
}

function sendVideo($chat_id, $video)
{
    $params = [
        'chat_id' => $chat_id,
        'video' => $video,
    ];

    return json_decode(request('/sendVideo', $params));
}

function sendDocument($chat_id, $document)
{
    $params = [
        'chat_id' => $chat_id,
        'document' => $document,
    ];

    return json_decode(request('/sendDocument', $params));
}