<?php
session_start();
require_once (__DIR__ . '/core/config.php');
require_once (__DIR__ . '/Database.php');

$db = new DatabaseAcceser();
$list = $db->getRentedToolList($_SESSION['company_password']);
if(!isset($_SESSION['USER'])){
    header("Location: index.php");
    exit;
}
if(isset($_SESSION['rental'])){
    ?>
    <div class="alert alert-danger" role="alert" id="modal-content">
        <p>ツールを貸し出しました。</p>
    </div><?php
    unset($_SESSION['rental']);
}
if(isset($_SESSION['return'])){
    ?>
    <div class="alert alert-danger" role="alert" id="modal-content">
        <p>ツールを返却しました。</p>
    </div><?php
    unset($_SESSION['return']);
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>HOME</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link href="htdocs/reset.css" rel="stylesheet" type="text/css">
    <link href="htdocs/css.css" rel="stylesheet" type="text/css">

</head>
<body>
<div class="nav">
    <nav>
        <ul>
            <li  id="check" class="home"><a href=""><img src="htdocs/home.png" alt="home" border="0"></a></li>
            <li class="content"><a href="rental.php">貸し出し</a></li>
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
    <div class="rental_log_title"><p>現在貸し出し中のツール</p></div>
    <table class="rental_log_content">
        <tr>
            <th>ツール名</th>
            <th>　　貸し出し人：貸し出し日時</th>
            <th class="rental_log_contents_location">使用場所</th>
        </tr>
        <?php foreach ($list as $name=>$item) : ?>
        <tr>
            <td class="rental_log_contents_name"><?= h($item['toolname']); ?></td>
            <td><?php if($item['user_id'] === $_SESSION['user_id']): ?>
                    <?php $userID = $db->getPersonnelid($item['user_id']); ?>
                    <?php echo "　: 「<span class=\"rental_log_self\">あなた</span>」が" . $item['usedate'] . "に借りています。" ?>
                <?php else: $userID = $db->getPersonnelid($item['user_id']); echo "　: " . h($userID['username']) . "さんが" . $item['usedate'] .  "に借りています" ?>
                <?php endif; ?>
            </td>
            <td style="padding-left: 10px"><?= h($item['pointofuse']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</div>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/06
 * Time: 0:06
 */
