<?php
require_once('config.php');
// Facebook IDを入れる
$user = "";
// プロフィール情報を入れる
$user_profile = "";
// 友人の情報を入れる
$user_friend = "";

// Get User ID
$user = $facebook->getUser();

if($user){
    try {
        $user_profile = $facebook->api('/me');
        $user_friend = $facebook->api('/me/friends?fields=gender');
    } catch(FacebookApiException $e) {
        error_log($e);
    }
}

if($user){
    $logoutUrl = $facebook->getLogoutUrl();
} else {
    $scope = array('scope' => 'publish_stream,read_friendlists');
    $loginUrl = $facebook->getLoginUrl($scope);
}
?>
<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
	<meta charset="UTF-8">
	<title>EventApp</title>
</head>
<body>
	<h1>Login?</h1>
	<?php if($user):?>
    <img src="https://graph.facebook.com/<?php echo $user;?>/picture">
    <?php endif;?>
    
	<?php if(empty($user)):?>
    <a href="<?php echo $loginUrl;?>">Login</a>
    <?php endif;?>
    
    <h3>あなたの異性の友達</h3>
    <?php for($i = 0; $i < count(@$user_friend['data']); $i++):?>
        <?php if(@$user_friend['data'][$i]['gender'] != $user_profile['gender']):?>
        	<a href="wall.php?id=<?php echo $user_friend['data'][$i]['id'];?>">
        		<img src="https://graph.facebook.com/<?php echo $user_friend['data'][$i]['id'];?>/picture" alt="" />
        	</a>
        <?php endif;?>
    <?php endfor;?>
</body>
</html>
