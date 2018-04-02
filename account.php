<?php
session_start();
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/11
 * Time: 5:03
 */

require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/core/config.php');
if(!isset($_SESSION['USER'])){
    header("Location: index.php");
    exit;
}
$errorMassage = "";
if(isset($_SESSION['username'],$_SESSION['userpassword1'])){
    ?>
    <div><font class="alert alert-danger" role="alert" color="#ff0000"><?= "ユーザー名：" . h($_SESSION['username']) . " パスワード：" .  h($_SESSION['userpassword1'])
        . " で新規登録しました、忘れないように気をつけてください。"; ?></font> </div><?php
    unset($_SESSION['username'],$_SESSION['userpassword1']);
}
if(isset($_SESSION['delete'])){
    ?>
    <div class="alert alert-danger" role="alert" id="modal-content">
        <p>ユーザーを削除しました。</p>
    </div><?php
    unset($_SESSION['delete']);
}
$db = new DatabaseAcceser();
$list = $db->getPersonnelList($_SESSION['company_password']);
if(isset($_POST['tools'])) {
    $tools = $_POST['tools'];
    foreach ($_POST['tools'] as $item) {
        $db->deletePersonner($_POST['tools'], $_SESSION['company_password'], $_SESSION['USER']);
    }
    $_SESSION['delete'] = "a";
//    var_dump($_POST['tools']);
    header("Location: account.php");
}
if(isset($_POST['signUp'])) {
    if (empty($_POST['userpassword1'])) {
        $errorMassage = "パスワードが未入力です。";
    } else if (empty($_POST['userpassword2'])) {
        $errorMassage = "確認用のパスワードが未入力です。";
    } else if (empty($_POST['username'])) {
        $errorMassage = "ユーザー名が未入力です。";
    }
    if (!empty($_POST['userpassword1']) && !empty($_POST['username']) && $_POST['userpassword1'] === $_POST['userpassword2']) {
        $username = $_POST['username'];
        $userpassword = $_POST['userpassword1'];
//        $company_password = $_POST['company_password1'];

        $db = new DatabaseAcceser();
//      新規作成：企業、ユーザー
        $errorMassage = $db->creatPesonnel($username, $userpassword, $_SESSION['company_password']);
        if ($errorMassage === NULL) {
            $_SESSION['username'] = $username;
            $_SESSION['userpassword1'] = $userpassword;
            unset($_POST['signUp']);
            header("Location: account.php");
        }


    } else if ($_POST['userpassword1'] != $_POST['userpassword2']) {
        $errorMassage = "パスワードに誤りがあります。";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>アカウント管理</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link href="htdocs/reset.css" rel="stylesheet" type="text/css">
    <link href="htdocs/css.css" rel="stylesheet" type="text/css">

</head>
</bod>
<div class="nav">
    <nav>
        <ul>
            <li class="home"><a href="home.php"><img src="htdocs/home.png" alt="home" border="0"></a></li>
            <li class="content"><a href="rental.php">貸し出し</a></li>
            <li class="content"><a href="return.php">返却</a></li>
            <li class="content"><a href="tool.php">ツール管理</a></li>
            <li id="check" class="content"><a href="">アカウント管理</a></li>
            <li class="logout"><a href="logout.php"><img src="htdocs/logout.png" alt="home" border="0"></a></li>
        </ul>
    </nav>
</div>
<div class="body">
<div class="overview">
    <p>ようこそ<u><?= h($_SESSION['USER']); ?></u>さん</p>
</div>
<div class="rental_log_title"><p>登録されているユーザー一覧</p></div>
    <table class="rental_log_content">
        <tr>
            <th></th>
            <th>ツール名</th>
        </tr>
        <form action="" method="post">
            <tr>
                <?php foreach ($list as $name=>$item) : ?>
                    <td><input type="checkbox" name="tools[]" value="<?= h($item['username']); ?>"></td>
                    <td><?= h($item['username']); ?></td>
            </tr>
            <?php endforeach; ?>
    </table>
            <h1>チェックを入れた社員を削除します。</h1>
            <input class="button" type="submit" value="削除">
        </form>
    </table>
<hr>
<p>ユーザー新規登録</p>
<form id="loginForm" name="loginForm" action="" method="post">
    <fieldset>

        <div><font color="#ff0000"><?= h($errorMassage); ?></font> </div>
        <!--        <div><font color="#0000ff">--><?//= h($signUpMessage); ?><!--</font> </div>-->
        <label for="username">ユーザー名</label><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if(!empty($_POST["username"])) {echo h($_POST['username']);}; ?>" required>
        <br>
        <label for="userpassword1">パスワード</label><input type="password" id="userpassword1" name="userpassword1" value="" placeholder="パスワードを入力" required>
        <br>
        <label for="userpassword2">パスワード（確認用）</label><input type="password" id="userpassword2" name="userpassword2" value="" placeholder="再度パスワードを入力" required>
        <input class="button" type="submit" name="signUp" value="新規登録">
    </fieldset>
</form>
</div>
</body>
</html>