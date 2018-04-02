<?php
session_start();
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/11
 * Time: 4:37
 */

require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/core/config.php');
if(!isset($_SESSION['USER'])){
    header("Location: index.php");
    exit;
}
$db = new DatabaseAcceser();
$list = $db->getRentalToolList($_SESSION['company_password']);
//var_dump($list);
if(isset($_POST['point'])){
    if (empty($_POST['point'])) {
        $errorMassage = "使用場所が未入力です。";
    }elseif(!empty($_POST['tools'])) {
        $poinofuse = $_POST['point'];
        $tools = $_POST['tools'];
        foreach ($_POST['tools'] as $item) {
            $db->rentalTool($item, $_SESSION['company_password'], $_SESSION['USER'], $poinofuse,$_SESSION['user_id']);
        }
        $_SESSION['rental'] = "a";
        header("Location: home.php");
    }else{
        echo "<div class=\"alert alert-danger\" role=\"alert\" id=\"modal-content\">
        <p>ツールが選択されていません。</p>
    </div>";
    }

}

//if(isset($_SESSION['rental'])) {
//    ?>
<!--    <div id="modal-content">-->
<!--        <p>ツールを貸し出ししました。</p>-->
<!--        <p><a id="modal-close" class="button-link">閉じる</a></p>-->
<!--    </div>--><?php
//    unset($_SESSION['rental']);
//}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>貸し出し画面</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link href="htdocs/reset.css" rel="stylesheet" type="text/css">
    <link href="htdocs/css.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="nav">
    <nav>
        <ul>
            <li  class="home"><a href="home.php"><img src="htdocs/home.png" alt="home" border="0"></a></li>
            <li id="check" class="content"><a href="">貸し出し</a></li>
            <li class="content"><a href="return.php">返却</a></li>
            <li class="content"><a href="tool.php">ツール管理</a></li>
            <li class="content"><a href="account.php">アカウント管理</a></li>
            <li class="logout"><a href="logout.php"><img src="htdocs/logout.png" alt="home" border="0"></a></li>
        </ul>
    </nav>
</div>
    <div class="body">
        <div class="overview">
            <p>ようこそ<u><?= h($_SESSION['USER']); ?></u>さん</p>
        </div>
        <div class="rental_log">
            <div class="rental_log_title"><p>貸し出しができるツール</p></div>
            <div>
                <table class="rental_log_content">
                    <tr>
                        <th></th>
                        <th>ツール名</th>
                    </tr>
                <form action="" method="post">
                    <tr>
                    <?php foreach ($list as $name=>$item) : ?>
                        <td><input type="checkbox" name="tools[]" value="<?= h($item['toolname']); ?>"></td>
                        <td><?= h($item['toolname']); ?></td>
<!--                        <label><input type="checkbox" name="tools[]" value="--><?//= h($item['toolname']); ?><!--">--><?//= h($item['toolname']); ?><!--</label>-->
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php if(!empty($list)) :?>
                    使用場所を入力してください。：<input type="text" name="point" placeholder="使用する場所" required><br>
                    <input class="button" type="submit" value="登録する">
                <?php else: echo "<p>使用できるツールが登録されていません。ツールの登録は<a href='tool.php'>ツール管理</a>から登録できます。"; ?>
                <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

</body>
</html>