<?php
require_once('config.php');

$other_fbid = h($_GET['id']);
if($_POST){
    $post_content = h($_POST['content']);
} else {
    $post_content = "";
}

$friend_info = $facebook->api($other_fbid);
?>
<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
	<meta charset="UTF-8">
	<title>ウォール投稿</title>
</head>
<body>
<?php if(empty($post_content)):?>
<img src="https://graph.facebook.com/<?php echo $other_fbid;?>/picture?width=150" alt="" />
<p><?php echo $friend_info['name'];?></p>
<form action="wall.php?id=<?php echo $other_fbid;?>" method="POST">
    <textarea name="content" id="content" cols="30" rows="10"><?php echo $friend_info['name'];?></textarea>
    <input type="submit" value="送信" />
</form>
<?php else:?>
	<?php
        try {
            $facebook->api("/{$other_fbid}/feed", 'POST', array(
                    'message' => $post_content,
                    'link' => 'https://www.google.co.jp/'
                    ));
        } catch (FacebookApiException $e) {
            error_log($e);
        } ?>
    <h3>投稿しました。</h3>
    <p>友達のウォールを<a href="https://www.facebook.com/<?php echo $other_fbid;?>" target="_blank">見てみる</a></p>
    <p><a href="./">トップに戻る</a></p>
<?php endif;?>
</body>
</html>
