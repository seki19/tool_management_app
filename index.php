<?php
//session_start();
require_once (__DIR__ . '/signUp.php');

require_once(__DIR__ . '/dbconnect.php');
require_once(__DIR__ . '/login.php');
require_once (__DIR__ . '/core/config.php');
//require_once (__DIR__ . '/signUp.php');

ob_start();
if(isset($_SESSION['username'], $_SESSION['userpassword1'], $_SESSION['company_name'], $_SESSION['company_password1'])){
   ?> <div><font class="alert alert-danger" role="alert" color="#ff0000"><?= "ユーザー名：" . h($_SESSION['username']) . " パスワード：" .  h($_SESSION['userpassword1'])
        . " 企業名：" . h($_SESSION['company_name']) . " 企業コード：" . h($_SESSION['company_password1'])
        . " で新規登録しました、忘れないように気をつけてください。"; ?></font> </div><?php

    $_SESSION = array();
    @session_destroy();
}
?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link href="htdocs/index.css" rel="stylesheet" type="text/css">

</head>
<body>

<div class="col-xs-6 col-xs-offset-3">
    <form method="post">
        <h1>ログインフォーム</h1>
        <div class="form-group">
            企業コード<input type="company_id" class="form-control" name="company_id" placeholder="企業コード" required>
        </div>
        <div class="form-group">
           ユーザー名 <input type="username" class="form-control" name="username" placeholder="ユーザー名" required>
        </div>
        <div class="form-group">
           パスワード <input type="password" class="form-control" name="password" placeholder="ユーザーパスワード" required>
        </div>
        <button type="submit" class="btn btn-default" name="login">ログインする</button>
    </form>
        <br>
        <a href="sign.php">企業新規登録はこちら</a>
</div>
<div class="col-xs-6 col-xs-offset-3">
    <div class="container">
        <dl>
            <dt class="container__new">
                新着情報
            </dt>
            <dd class="contaier__newcolumn">
                2018/02/18:バグを修正、仕様変更（他人が借りたツールの返却ができなくなりした）。
            </dd>
        </dl>
    </div>
</div>

</html>
<?php
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/04
 * Time: 14:46
 */