<?php
session_start();
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/11
 * Time: 5:01
 */

require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/core/config.php');
if(!isset($_SESSION['USER'])){
    header("Location: index.php");
    exit;
}
if(isset($_SESSION['delete'])){
    ?>
    <div class="alert alert-danger" role="alert" id="modal-content">
        <p>ツールを削除しました。</p>
    </div><?php
    unset($_SESSION['delete']);
}
if(isset($_SESSION['create'])){
    ?>
    <div class="alert alert-danger" role="alert" id="modal-content">
        <p>ツールを新規登録しました。</p>
    </div><?php
    unset($_SESSION['create']);
}
$db = new DatabaseAcceser();
$list = $db->getToolList($_SESSION['company_password']);
if(isset($_POST['tools'])) {
    $tools = $_POST['tools'];
    foreach ($_POST['tools'] as $item) {
        $db->deleteTool($_POST['tools'], $_SESSION['company_password'], $_SESSION['USER']);
    }
    $_SESSION['delete'] = "a";
    header("Location: tool.php");
}
if(isset($_POST['toolname'])){
//    var_dump($_POST['toolname']);
    $db->createTool( $_SESSION['company_password'],$_POST['toolname'], $_SESSION['USER']);
    $_SESSION['create'] = "a";
    header("Location: tool.php");
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ツール管理</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link href="htdocs/reset.css" rel="stylesheet" type="text/css">
    <link href="htdocs/css.css" rel="stylesheet" type="text/css">

</head>
<body>
<body>
<div class="nav">
    <nav>
        <ul>
            <li class="home"><a href="home.php"><img src="htdocs/home.png" alt="home" border="0"></a></li>
            <li class="content"><a href="rental.php">貸し出し</a></li>
            <li class="content"><a href="return.php">返却</a></li>
            <li id="check" class="content"><a href="">ツール管理</a></li>
            <li class="content"><a href="account.php">アカウント管理</a></li>
            <li class="logout"><a href="logout.php"><img src="htdocs/logout.png" alt="home" border="0"></a></li>
        </ul>
    </nav>
</div>
<div class="body">
<!--<h1>現在登録されているツール一覧</h1><hr>-->
    <div class="overview">
        <p>ようこそ<u><?= h($_SESSION['USER']); ?></u>さん</p>
    </div>
    <div class="rental_log">
        <div class="rental_log_title"><p>登録されているツール一覧</p></div>
<form action="" method="post">
    <table class="rental_log_content">
        <tr>
            <th></th>
            <th>ツール名</th>
        </tr>
        <?php foreach ($list as $name=>$item) : ?>
            <tr>
                <label for="delete__tools">
                <td><input type="checkbox"  id="delete__tools" name="tools[]" value="<?= h($item['toolname']); ?>"></td>
                <td class="rental_log_contents_name"><?= h($item['toolname']); ?> </td></label>
            </tr>
        <?php endforeach; ?>
    </table>
    <h1>チェックを入れたツールを削除します。</h1>
    <input class="button" type="submit" value="削除">
</form>
<!--<div>-->
<!--    <form action="" method="post">-->
<!--        --><?php //foreach ($list as $name=>$item) : ?>
<!--            <label><input type="checkbox" name="tools[]" value="--><?//= h($item['toolname']); ?><!--">--><?//= h($item['toolname']); ?><!--</label>-->
<!--        --><?php //endforeach; ?>
<!--        <h1>チェックを入れたツールを削除します。</h1>-->
<!--        <input type="submit" value="削除">-->
<!--    </form>-->
<!--</div>-->
<hr>
<form id="newTool" name="newTool" action="" method="post">
    <fieldset>
        <legend>ツール新規登録</legend>
        <label for="toolname"></label><input type="text" id="toolname" name="toolname" placeholder="ツール名を入力" value="" required>
        <input class="button" type="submit" value="新規登録">
    </fieldset>
</form>
</div>

</body>
</html>