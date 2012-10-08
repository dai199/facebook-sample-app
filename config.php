<?php
function h($s) {
    return htmlspecialchars($s);
}

require_once('facebook-php-sdk/src/facebook.php');

$facebook = new Facebook(array(
    'appId' => 'YOUR_APP_ID',
    'secret' => 'YOUR_APP_SECRET'
));
