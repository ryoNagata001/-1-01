<?php
session_start();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

try{
    require_once("../pdo.php");
}catch(PDOException $e){
    var_dump($e->getMessage());
    exit;
}

$stmt = $db->prepare("select * from users where name = :name and email = :email and password = :password");
$stmt->execute([
    ':name'=>$username,
    ':email'=>$email,
    ':password'=>$password
]);

$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
var_dump($rec[0]["id"]);
$db = null;

if($rec == false){
    echo "正しい値を入力してください";
    echo '<a href="new.php">ログイン画面へ戻る</a>';
}else{
    $_SESSION['login'] = 1;
    $_SESSION['user_id'] = $rec[0]["id"];
    header('Location: ../index.php');
}
