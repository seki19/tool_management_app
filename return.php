<?php
session_start();
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/11
 * Time: 5:02
 */

require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/core/config.php');
if(!isset($_SESSION['USER'])){
    header("Location: index.php");
    exit;
}
$db = new DatabaseAcceser();
$list = $db->getRentToolList($_SESSION['company_password'],$_SESSION['user_id']);
if(isset($_POST['tools'])) {
    $tools = $_POST['tools'];
    foreach ($_POST['tools'] as $item) {
        $db->returnTool($item, $_SESSION['company_password'], $_SESSION['USER'],$_SESSION['user_id']);
    }
    $_SESSION['return'] = "a";
    header("Location: home.php");
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>返却画面</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link href="htdocs/reset.css" rel="stylesheet" type="text/css">
    <link href="htdocs/css.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="nav">
    <nav>
        <ul>
            <li class="home"><a href="home.php"><img src="htdocs/home.png" alt="home" border="0"></a></li>
            <li class="content"><a href="rental.php">貸し出し</a></li>
            <li id="check" class="content"><a href="">返却</a></li>
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
        <div class="rental_log_title"><p>あなたが現在貸し出し中のツール</p></div>
        <?php if(!empty($list)): ?>
        <form action="" method="post">
        <table class="rental_log_content">
            <tr>
                <th></th>
                <th>ツール名</th>
                <th>　　貸し出し日時</th>
                <th class="rental_log_contents_location">使用場所</th>
            </tr>
            <?php foreach ($list as $name=>$item) : ?>
                <tr>
                    <td><input type="checkbox" name="tools[]" value="<?= h($item['toolname']); ?>"></td>
                    <td class="rental_log_contents_name"><?= h($item['toolname']); ?></td>
                    <td><?php if($item['user_id'] === $_SESSION['user_id']): ?>
                            <?php $userID = $db->getPersonnelid($item['user_id']); ?>
                            <?php echo "　: " . $item['usedate'] . "に借りています。" ?>
                        <?php else: $userID = $db->getPersonnelid($item['user_id']); echo "　: " . h($userID['username']) . "さんが" . $item['usedate'] .  "に借りています" ?>
                        <?php endif; ?>
                    </td>
                    <td style="padding-left: 10px"><?= h($item['pointofuse']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
            <input class="button" type="submit" value="返却する">
        </form>
        <? else: echo "<p>現在あなたが貸し出し中のツールはありません。"; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>