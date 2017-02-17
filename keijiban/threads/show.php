<?php
session_start();
$thread_title = $_GET['thread_title'];
$thread_id = $_GET['thread_id'];
?>
    <h1><?php echo $thread_title;?></h1>
<?php
//dbと接続
try{
    require_once('../pdo.php');
}catch(PDOException $e){
    var_dump($e->getMessage());
    exit;
}
//commentsからid合うものだけfetch
$stmt = $db->prepare("select * from comments where thread_id = :id");
$stmt->execute([
    ':id'=>$thread_id
]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
$number = 1;
//描画(スレタイ描画を参考に)
foreach($comments as $comment):
    echo $number . " ";
$stmt = $db->prepare("select name from users where id = :id");
$stmt->execute([
    ':id'=>$comment['user_id']
]);
$name = $stmt->fetch(PDO::FETCH_ASSOC);
echo $name['name'] . " " . $comment['created_at'];
echo "<br>";
echo $comment['content']. "<br>";
$number += 1;
if($comment['user_id'] == $_SESSION['user_id']){
    ?>
<form action="../comments/update.php" method="post">
<input type="hidden" name="comment_id" value="<?php echo $comment['id']?>">
<input type="hidden" name=content"" value="<?php echo $comment['content']?>">
<input type="submit" value="edit">
</form>
<?php
}
echo"<br>";
endforeach;
//コメント追加欄(hiddenでthread_idと、sessionからuser_id載せる
if($_SESSION['login'] == 1){
?>
<p>コメントする</p>
<form action="../comments/create.php" method="post">
<textarea name="content" rows="4" cols="40"></textarea>
<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>">
<input type="hidden" name="thread_id" value="<?php echo $thread_id;?>">
<p><input type="submit" value="コメント"></p>
<?php
}
?>
<a href="../index.php">トップページに戻る</a>
<a href="show_all.php">スレッド一覧に戻る</a>
