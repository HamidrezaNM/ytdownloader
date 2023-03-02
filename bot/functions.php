<?php

global $token;
$token = '5470506972:AAG5haKY329tYlJZRBQmSZ8AWA6k2Lh7I10';
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

function BanUser($chat_id, $user_id)
{
    $website = "https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY";
    $params = [
        'chat_id' => $chat_id,
        'user_id' => $user_id,
    ];
    $ch = curl_init($website . '/kickChatMember');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}

function unBanUser($chat_id, $user_id)
{
    $website = "https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY";
    $params = [
        'chat_id' => $chat_id,
        'user_id' => $user_id,
    ];
    $ch = curl_init($website . '/unbanChatMember');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
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

function SendMessageWithReply($chat_id, $text, $message_i_d)
{
    file_get_contents("https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY" . "/sendmessage?chat_id=" . $chat_id . "&text=" . $text . "&parse_mode=Markdown&reply_to_message_id=" . $message_i_d);
}

function SendMessageWithOutMarkDown($chat_id, $text)
{
    file_get_contents("https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY" . "/sendmessage?chat_id=" . $chat_id . "&text=" . $text . "&parse_mode=html");
}

function GetWarns($id)
{
    $c = file_get_contents("Users.json");
    $p = json_decode($c, TRUE);
    return $p["main-data"]["$id"]["stat"]["Warns"][0];
}

function GetLevel($id)
{
    $c = file_get_contents("Users.json");
    $p = json_decode($c, TRUE);
    return $p["main-data"]["$id"]["stat"]["Level"][0];
}

function GetLikes($id)
{
    $c = file_get_contents("Users.json");
    $p = json_decode($c, TRUE);
    return $p["main-data"]["$id"]["stat"]["Likes"][0];
}

function IsExit($id)
{
    $c = file_get_contents("Users.json");
    $p = json_decode($c, TRUE);
    $d = $p["main-data"]["$id"];
    if ($d == $id) {
        return true;
    }
}

function GetTimeStampSaved($id)
{
    $c = file_get_contents("Users.json");
    $p = json_decode($c, TRUE);
    return $p["main-data"]["$id"]["stat"]["latest-scoring"][0];
}

function GetIsAdmin($chat_id, $user_id)
{
    $website = "https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY";
    $params = [
        'chat_id' => $chat_id,
        'user_id' => $user_id,
    ];
    $ch = curl_init($website . '/getChatMember');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result);
}

function check_scoring($user_id)
{
    $values = json_decode(file_get_contents('Users.json'), TRUE);
    if (abs(intval(explode('-', date('d-m-Y', getdate()[0]))[0]) - intval(explode('-', date('d-m-Y', $values["main-data"]["$user_id"]["stat"]["latest-scoring"][0]))[0])) == 0 && intval(explode('-', date('d-m-Y', getdate()[0]))[1]) == intval(explode('-', date('d-m-Y', $values["main-data"]["$user_id"]["stat"]["latest-scoring"][0]))[1] && intval(explode('-', date('d-m-Y', getdate()[0]))[2]) == intval(explode('-', date('d-m-Y', $values["main-data"]["$user_id"]["stat"]["latest-scoring"][0]))[2]))) {
        return false;
    } else {
        return true;
    }
    unset($values);
}


function getMax($element)
{
    global $nums;
    $users = json_decode(file_get_contents('Users.json'), TRUE);
    $ids = array_keys($users["main-data"]);
    for ($x = 0; $x <= count($ids) - 1; $x++) {
        $nums["$ids[$x]"] = $users["main-data"][$ids[$x]]["stat"]["$element"][0];
    }
    unset($ids);
    asort($nums);
    $nums = array_reverse($nums, true);
    if (count($nums) > 10) {
        $nums = array_slice($nums, 0, 10, true);
    }
}
function pinChatMessage($chat_id, $messageID)
{
    file_get_contents("https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY" . "/pinChatMessage?chat_id=" . $chat_id . "&message_id=" . $messageID);
}
function unpinChatMessage($chat_id, $messageID)
{
    file_get_contents("https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY" . "/unpinChatMessage?chat_id=" . $chat_id . "&message_id=" . $messageID);
}
function promoteChatMember($chat_id, $userID)
{
    file_get_contents("https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY" . "/promoteChatMember?chat_id=" . $chat_id . "&user_id=" . $userID);
}
function setChatAdministratorCustomTitle($chat_id, $userID, $customTitle)
{
    file_get_contents("https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY" . "/setChatAdministratorCustomTitle?chat_id=" . $chat_id . "&user_id=" . $userID . "&custom_title=" . $customTitle);
}
// function sendPhoto($chat_id, $photo)
// {
//     file_get_contents("https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY" . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $photo);
// }
function sendPhotoWithCaption($chat_id, $photo, $caption)
{
    file_get_contents("https://api.telegram.org/bot1373946259:AAErNZ3P6afENhS6LJGqxkDrhqK9eIiaRlY" . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $photo . "&caption=" . $caption);
}
