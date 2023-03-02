<?php

require 'vendor/autoload.php';
use YouTube\YouTubeDownloader;
use YouTube\Exception\YouTubeException;

$youtube = new YouTubeDownloader();

try {
    echo ($youtube->getVideoInfo("aqz-KE-bpKQ")->getPlayerResponse());
    $downloadOptions = $youtube->getDownloadLinks("aqz-KE-bpKQ");

    if ($downloadOptions->getAllFormats()) {
        echo $downloadOptions->getFirstCombinedFormat()->url;
    } else {
        echo 'No links found';
    }

} catch (YouTubeException $e) {
    echo 'Something went wrong: ' . $e->getMessage();
}
?>
<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <?php echo '<p>Hello World</p>'; ?> 

    <!--
    This script places a badge on your repl's full-browser view back to your repl's cover
    page. Try various colors for the theme: dark, light, red, orange, yellow, lime, green,
    teal, blue, blurple, magenta, pink!
    -->
    <script src="https://replit.com/public/js/replit-badge.js" theme="blue" defer></script> 
  </body>
</html>