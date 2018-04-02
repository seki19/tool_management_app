<?php
session_start();
require_once (__DIR__ . '/core/config.php');
if(!isset($_SESSION['USER'])){
    header("Location: index.php");
    exit;
}
if(isset($_SESSION["USER"])){
    $errorMassage = "ログアウトしました。";
}else{
    $errorMessage = "セッションがタイムアウトしました。";
}

$_SESSION = array();
@session_destroy();
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ログアウト</title>
</head>
<body>
<h1>ログアウト画面</h1>
<div><?= h($errorMassage);?></div>
<ul>
    <li><a href="index.php">ログイン画面に戻る</a></li>
</ul>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/07
 * Time: 22:25
 */