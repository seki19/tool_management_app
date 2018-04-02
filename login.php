<?php
session_start();
require_once (__DIR__ . '/Database.php');

if(isset($_POST['login'])){
  // var_dump($_POST['login']);
    $company_id =h($_POST['company_id']);
    $username =h($_POST['username']);
    $password =h($_POST['password']);
  //  var_dump($_POST['login']);
    $db = new DatabaseAcceser();
    $stmt = $db->accessDatabase()->prepare("SELECT * FROM tbl_user WHERE username = ? AND company_password = ?");
    $stmt->bindValue(1,$username);
    $stmt->bindValue(2,$company_id);
//    $stmt->bindValue(3,$password);
    $stmt->execute();
    $rows = $stmt->fetch();
    $db_hashed_pwd = $rows['password'];

    if(password_verify($password,$db_hashed_pwd)){
      if($rows['company_password'] === $company_id) {
          $_SESSION['USER'] = $username;
          $_SESSION['company_password'] = $company_id;
          $_SESSION['user_id'] = $rows['user_id'];
          header("Location: home.php");
          exit;
      }else{ ?>
          <div class="alert alert-danger" role="alert">企業コードが一致しません。</div>
        <?php
      }
    } else { ?>
        <div class="alert alert-danger" role="alert">ユーザー名とパスワードが一致しません。</div>
    <?php }
}
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/04
 * Time: 15:46
 */