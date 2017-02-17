<?php
session_start();

//ログアウト
if($_SESSION['login'] == 1){
    unset($_SESSION['login']);
}else{
    echo "ログインしてください";
    print '<a href="new.php">ログイン画面</a>';
    exit();
}

//ログイン画面
echo 'ログアウト成功 => ';
print '<a href="new.php">ログイン画面</a>';
