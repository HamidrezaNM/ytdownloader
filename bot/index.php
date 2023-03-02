<?php
include 'functions.php';

require '../vendor/autoload.php';
use YouTube\YouTubeDownloader;
use YouTube\Exception\YouTubeException;

$youtube = new YouTubeDownloader();

date_default_timezone_set('Asia/Tehran');

$update = json_decode(file_get_contents("php://input"), TRUE);

$chatId = $update["message"]["chat"]["id"];
$messageText = $update["message"]["text"];
$messageId = $update["message"]["message_id"];
$userId = $update["message"]["from"]["id"];
$callback = $update['callback_query'];
$callbackMessage = $update['callback_query']['message'];
$callbackUserId = $callback['from']['id'];

if ($callback) {
	$preparingVideo = sendMessage($callbackUserId, 'درحال پردازش ویدیو ...');

	$videoId = explode(' ', $callback['data'])[0];
	$linkId = explode(' ', $callback['data'])[1] - 1;

	try {
		$downloadOptions = $youtube->getDownloadLinks($videoId);
		$videoInfo = $downloadOptions->getInfo();
		$_title = $videoInfo->getTitle();

	if ($downloadOptions->getAllFormats()) {
			$links = $downloadOptions->getAllFormats();
	} else {
			echo 'No links found';
	}

	} catch (YouTubeException $e) {
			sendMessage($callbackUserId, 'Something went wrong: ' . $e->getMessage());
	}

	$item = $links[$linkId];
	$file_url = $item->url;
	$isAudio = explode('/', explode(' ', $item->mimeType)[0])[0] == 'audio' && $item->audioQuality != null;

	if($isAudio) {
		$audioLabel = '🎵 کیفیت : ' . strtolower(explode('_', $item->audioQuality)[2]);
	}

	$keyboard = json_encode([
			"inline_keyboard" => [
					[
							[
								"text" => "📥 لینک دانلود",
								"url" => $file_url
							],
					]
			]
	]);

	$typeLabel = $isAudio ? 'موزیک' : 'ویدیو';

	$qualityLabel = $isAudio ? $audioLabel : "🖼 کیفیت : $item->qualityLabel";
	$file_size = formatBytes($item->contentLength);
	$ext = explode(';', explode('/', explode(' ', $item->mimeType)[0])[1])[0];
	
	$MText = "✅ $typeLabel با موفقیت دریافت شد \n\n 🎬 $_title \n\n $qualityLabel \n 🗳 حجم : $file_size \n 📄 فرمت : $ext";

	sendMessageWithKeyboard($callbackUserId, $MText, $keyboard, $callbackMessage['message_id']);
	
	deleteMessage($callbackUserId, $preparingVideo);

	sendVideo($callbackUserId, $file_url);
}

if ($messageText) {
	if (preg_match("/youtube.com\/watch\?v=(\S+)/", $messageText)) {
			preg_match("/youtube.com\/watch\?v=(\S+)/", $messageText, $videoId);
	} else if (preg_match("/youtu.be\/(\S+)/", $messageText)) {
			preg_match("/youtu.be\/(\S+)/", $messageText, $videoId);
	} else {
			return;
	}

	$preparingMessage = sendMessage($userId, 'درحال ارسال درخواست');
	// SendMessage('1283437650', $videoId[1]);
	$videoId = $videoId[1];

	editMessageText($userId, $preparingMessage, 'درحال دریافت اطلاعات');

	try {
		$downloadOptions = $youtube->getDownloadLinks($videoId);
		$videoInfo = $downloadOptions->getInfo();

		$title = $videoInfo->getTitle();
		$title = strlen($title) > 128 ? substr($title, 0, 128).'...' : $title;
		$description = $videoInfo->getShortDescription();
		$description = strlen($description) > 420 ? substr($description, 0, 420).'...' : $description;
		$viewcount = number_format($videoInfo->getViewCount());
		$thumbnail = $videoInfo->getThumbnail()['thumbnails'][2]['url'];

	if ($downloadOptions->getAllFormats()) {
			$videos = $downloadOptions->getAllFormats();
	} else {
			echo 'No links found';
	}

	} catch (YouTubeException $e) {
			echo 'Something went wrong: ' . $e->getMessage();
	}

	deleteMessage($userId, $preparingMessage);

	$keyboard = array(
			"inline_keyboard" => array(
					array()
			)
	);

	$i = 0;

	foreach ($videos as $item) {
			$i++;
			if ($item->url != null) {
				$file_size = formatBytes($item->contentLength);
				$isAudio = explode('/', explode(' ', $item->mimeType)[0])[0] == 'audio' && $item->audioQuality != null;

				if($isAudio) {
					$audioLabel = '🎵 ' . strtolower(explode('_', $item->audioQuality)[2]);
				}
				
				$array = array("text" =>
											($isAudio ? $audioLabel : 
											$item->qualityLabel) . ' ' . 
											explode(';', explode('/', explode(' ', $item->mimeType)[0])[1])[0] . ' ' . 
											$file_size, "callback_data" => $videoId . ' ' . $i);

				array_push($keyboard['inline_keyboard'][count($keyboard['inline_keyboard']) - 1], $array);
				if ($i % 2 == 0) {
					array_push($keyboard['inline_keyboard'], array());
				}
			}
	}

	$MessageText = "🎬 $title \n\n📝 $description \n\n👁 $viewcount";

	sendPhotoMessageWithKeyboard($userId, $thumbnail, $MessageText, json_encode($keyboard));
}

function formatBytes($size, $precision = 2)
{
	$base = log($size, 1024);
	$suffixes = array('', 'KB', 'MB', 'GB', 'TB');

	return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}
