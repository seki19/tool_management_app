<?php
//session_start();
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/08
 * Time: 0:46
 */
require_once (__DIR__ . '/core/config.php');
require_once (__DIR__ . '/Database.php');

$errorMassage = "";
$signUpMessage = "";

if(isset($_POST['signUp'])) {
    if (empty($_POST['userpassword1'])) {
        $errorMassage = "パスワードが未入力です。";
    } else if (empty($_POST['userpassword2'])) {
        $errorMassage = "確認用のパスワードが未入力です。";
    } else if (empty($_POST['username'])) {
        $errorMassage = "ユーザー名が未入力です。";
    } else if (empty($_POST['company_name'])) {
        $errorMassage = "企業名が未入力です。";
    } else if (empty($_POST['company_password1'])) {
        $errorMassage = "企業パスワードが未入力です。";
    } else if (empty($_POST['company_password2'])) {
        $errorMassage = "確認用の企業パスワードが未入力です。";
    }

    if(strlen($_POST['company_password1']) === 6){
        if(preg_match("/^[a-zA-Z0-9]+$/", $_POST['company_password1'])){
            $company_password = $_POST['company_password1'];
        }
    }else{
        $errorMassage = "企業コードは6文字の英数字を入力してください。";
    }
    if (!empty($_POST['userpassword1']) && !empty($_POST['username']) && !empty($_POST['company_name']) && !empty($company_password) && $_POST['userpassword1'] === $_POST['userpassword2'] && $company_password === $_POST['company_password2']) {
        $username = $_POST['username'];
        $userpassword = $_POST['userpassword1'];
        $company_name = $_POST['company_name'];
//        $company_password = $_POST['company_password1'];

        $db = new DatabaseAcceser();
//      新規作成：企業、ユーザー
        $errorMassage = $db->creatCompany($company_password,$company_name);
        if($errorMassage === NULL){
            $user = $db->creatPesonnel($username,$userpassword,$company_password);
            $_SESSION['username'] = $username;
            $_SESSION['userpassword1'] = $userpassword;
            $_SESSION['company_name'] = $company_name;
            $_SESSION['company_password1'] = $company_password;
            header("Location: index.php");
            exit();
        }

    } else if ($_POST['userpassword1'] != $_POST['userpassword2']) {
        $errorMassage = "パスワードに誤りがあります。";
    } else if ($_POST['company_password1'] != $_POST['company_password2']) {
        $errorMassage = "企業パスワードに誤りがあります。";

    }
}


