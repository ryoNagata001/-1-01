<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ユーザ登録</title>
</head>
<body>
<?php
//register/new.phpから受け取る
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

//データベースに接続
try{
    require_once('../pdo.php');
}catch(PDOException $e){
    var_dump($e->getMessage());
    echo "データベースに接続できませんでした.";
    exit;
}

$stmt = $db->prepare("insert into users (name, email, password) values (:name, :email, :password)");
$stmt->execute([
    ':name'=>$username,
    ':email'=>$email,
    ':password'=>$password
    ]);
//接続切る
$db = null;

echo "$usernameで登録完了しました";

print '<a href="../login/new.php">ログイン画面</a>';

?>
</body>
</html>

