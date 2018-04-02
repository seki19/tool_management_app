<?php
session_start();
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/10
 * Time: 4:00
 */

require_once (__DIR__ . '/core/config.php');
require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/signUp.php');
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link href="htdocs/index.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">
<h1>新規登録画面</h1>
<form id="loginForm" name="loginForm" action="" method="post">
    <fieldset>
        <div><font color="#ff0000"><?= h($errorMassage); ?></font> </div>
        <!--        <div><font color="#0000ff">--><?//= h($signUpMessage); ?><!--</font> </div>-->
        <div class="container_table">
        <table>
            <tr>
                <td>
                    <legend>新規登録フォーム</legend>
                </td>
            </tr>
            <tr>
                <td><label for="username">ユーザー名:</label></td>
                <td><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if(!empty($_POST["username"])) {echo h($_POST['username']);}; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="userpassword1">パスワード:</label>
                </td>
                <td>
                    <input type="password" id="userpassword1" name="userpassword1" value="" placeholder="パスワードを入力" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="userpassword2">パスワード（確認用）:</label>
                </td>
                <td>
                    <input type="password" id="userpassword2" name="userpassword2" value="" placeholder="再度パスワードを入力" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="company_name">企業名:</label>
                </td>
                <td>
                    <input type="text" id="company_name" name="company_name" placeholder="企業名を入力" value="<?php if(!empty($_POST["comapany_name"])) {echo h($_POST['comapany_name']);}; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="company_password1">企業コード:</label>
                </td>
                <td>
                    <input type="text" id="company_password1" name="company_password1" value="" placeholder="企業コードの入力" required>

                </td>
            </tr>
            <tr>
                <td>
                    <label for="company_password2">企業コード（確認用）:</label>
                </td>
                <td>
                    <input type="text" id="company_password2" name="company_password2" value="" placeholder="再度企業コードを入力" required>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" class="btn btn-default" id=""signUp name="signUp" value="新規登録">

                </td>
            </tr>
        </table>
        </div>
    </fieldset>
</form>
<hr>
<form action="index.php">
    <input type="submit" class="btn btn-default" value="戻る">
</form>
    <p>※企業内のユーザーを追加する際はログイン後にアカウント管理ページから追加できます。</p>
</div>
</body>
</html>
