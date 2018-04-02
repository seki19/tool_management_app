<?php
/**
 * Created by PhpStorm.
 * User: sekiikuya
 * Date: 2018/02/09
 * Time: 22:53
 */

require_once(__DIR__ . '/dbconnect.php');

class DatabaseAcceser{


    private $db;

    public function __construct()
    {
        $this->db = $this->accessDatabase();
    }

    public function accessDatabase(){
        try{

            $db = new PDO(DSN,DB_USERNAME,DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        }catch (PDOException $e){
            echo $e->getMessage();
            exit;
        }
    }
    public function creatCompany($company_password,$company_name){
        $company_password = $company_password;
        $company_name = $company_name;

        try {

            $stmt2 = $this->db->prepare("INSERT INTO tbl_company(CompanyName, CompanyPassword) VALUES (?,?)");
            $stmt2->execute(array($company_name, $company_password));


        } catch (PDOException $e) {
            $errorMassage = '企業コードがすでに使用されています。';
            return $errorMassage;
        }
    }

    public function createTool($company_password,$toolname,$username){
        $company_password = $company_password;
        $toolname = $toolname;
        $username = $username;
        try {
            $stmt2 = $this->db->prepare("INSERT INTO tool(toolname, Company_password, rentalstate) VALUES (?,?,0)");
            $stmt2->execute(array($toolname, $company_password));
            $this->setcreateToollog($toolname,$username,$company_password);

        } catch (PDOException $e) {
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function setcreateToollog($item,$username,$company_password){
        $toolname = $item;
        $username = $username;
        $company_password = $company_password;
        $rentalstate = "追加";
        $date = new DateTime();
        $datetime = $date->format('Y-m-d H:i:s');
        try{
            $stmt = $this->db->prepare("INSERT INTO log(toolname,user_name,rentaldate,company_password,rentalstate) VALUES (?,?,?,?,?)");
            $stmt->execute(array($toolname,$username,$datetime,$company_password,$rentalstate));
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function creatPesonnel($username,$userpassword,$company_password){
        $username = $username;
        $userpassword = $userpassword;
        $company_password = $company_password;

        try{
            $stmt1 = $this->db->prepare("INSERT INTO tbl_user(username, company_password, password) VALUES (?,?,?)");
            $stmt1->execute(array($username, $company_password, password_hash($userpassword, PASSWORD_DEFAULT)));

//            return array($username,$userpassword,$company_password);
        }catch (PDOException $e){
            $errorMassage = 'すでに同名のユーザーが登録されています。';
            return $errorMassage;
        }
    }
    public function getPersonnelList($company_password){
        $company_password = $company_password;

        try{
            $stmt = $this->db->prepare("SELECT * FROM tbl_user WHERE company_password = ?");
            $stmt->execute(array($company_password));
            $rows = $stmt->fetchAll();
            return $rows;
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function getPersonnelid($user_id){
        $user_id = $user_id;

        try{
            $stmt = $this->db->prepare("SELECT * FROM tbl_user WHERE user_id = ?");
            $stmt->execute(array($user_id));
            $rows = $stmt->fetch();
            return $rows;
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function getToolList($company_password){
        $company_password = $company_password;

        try{
            $stmt = $this->db->prepare("SELECT * FROM tool WHERE company_password = ?");
            $stmt->execute(array($company_password));
            $rows = $stmt->fetchAll();
//            var_dump($rows);
            return $rows;
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function getRentalToolList($company_password){
        $company_password = $company_password;

        try{
            $stmt = $this->db->prepare("SELECT * FROM tool WHERE company_password = ? AND rentalstate = 0");
            $stmt->execute(array($company_password));
            $rows = $stmt->fetchAll();
            return $rows;
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function getRentedToolList($company_password){
        $company_password = $company_password;

        try{
            $stmt = $this->db->prepare("SELECT * FROM tool WHERE company_password = ? AND rentalstate = 1");
            $stmt->execute(array($company_password));
            $rows = $stmt->fetchAll();
            return $rows;
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function getRentToolList($company_password, $user_id){
        $company_password = $company_password;
        $user_id = $user_id;

        try{
            $stmt = $this->db->prepare("SELECT * FROM tool WHERE company_password = ? AND user_id = ?  AND rentalstate = 1");
            $stmt->execute(array($company_password,$user_id));
            $rows = $stmt->fetchAll();
            return $rows;
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function rentalTool($tools, $company_password,$username,$pointofuse,$user_id){
        $tools = $tools;
        $company_password = $company_password;
        $username = $username;
        $pointofuse = $pointofuse;
        $user_id = $user_id;
        $date = new DateTime();
        $datetime = $date->format('Y-m-d H:i:s');
        try{
            $stmt = $this->db->prepare("UPDATE tool SET rentalstate = 1 , user_id = ?,usedate = ?, pointofuse = ? WHERE company_password = ? AND toolname = ?");
            $stmt->execute(array($user_id,$datetime,$pointofuse,$company_password,$tools));
            $this->setToollog($tools,$username,$pointofuse,$company_password);

        }catch (PDOException $e){
            $errorMassage = 'すでに借りられているツールがあります。';
            return $errorMassage;
        }
    }
    public function returnTool($tools, $company_password,$username,$user_id){
        $tools = $tools;
        $company_password = $company_password;
        $username = $username;
        $user_id=$user_id;
        $pointofuse = " ";
        try{
            $stmt = $this->db->prepare("UPDATE tool SET rentalstate = 0, user_id = ?, pointofuse = ? WHERE company_password = ? AND toolname = ?");
            $stmt->execute(array($user_id,$pointofuse,$company_password,$tools));
            $this->setruturnToollog($tools,$username,$company_password);
        }catch (PDOException $e){
            $errorMassage = 'すでに借りられているツールがあります。';
            return $errorMassage;
        }
    }
    public function setToollog($item,$username,$pointofuse,$company_password){
        $toolname = $item;
        $username = $username;
        $pointofuse = $pointofuse;
        $company_password = $company_password;
        $rentalstate = "貸出";
        $date = new DateTime();
        $datetime = $date->format('Y-m-d H:i:s');
        try{
            $stmt = $this->db->prepare("INSERT INTO log(toolname,user_name,pointofuse,rentaldate,company_password,rentalstate) VALUES (?,?,?,?,?,?)");
            $stmt->execute(array($toolname,$username,$pointofuse,$datetime,$company_password,$rentalstate));
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function setruturnToollog($item,$username,$company_password){
        $toolname = $item;
        $username = $username;
        $company_password = $company_password;
        $rentalstate = "返却";
        $date = new DateTime();
        $datetime = $date->format('Y-m-d H:i:s');
        try{
            $stmt = $this->db->prepare("INSERT INTO log(toolname,user_name,rentaldate,company_password,rentalstate) VALUES (?,?,?,?,?)");
            $stmt->execute(array($toolname,$username,$datetime,$company_password,$rentalstate));
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function deleteTool($tools, $company_password,$username){
        $tools = $tools;
        $company_password = $company_password;
        $username = $username;
        try{
            foreach($tools as $item){
                $stmt = $this->db->prepare("DELETE FROM tool WHERE company_password = ? AND toolname = ?");
                $stmt->execute(array($company_password,$item));
                $this->setdeleteToollog($item,$username,$company_password);
            }

        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function deletePersonner($username,$company_password){
        $company_password = $company_password;
        $username = $username;
        try{
            foreach($username as $item){
                $stmt = $this->db->prepare("DELETE FROM tbl_user WHERE company_password = ? AND username = ?");
                $stmt->execute(array($company_password,$item));
//                $this->setdeleteToollog($item,$username,$company_password);
            }

        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }
    public function setdeleteToollog($item,$username,$company_password){
        $toolname = $item;
        $username = $username;
        $company_password = $company_password;
        $rentalstate = "削除";
        $date = new DateTime();
        $datetime = $date->format('Y-m-d H:i:s');
        try{
            $stmt = $this->db->prepare("INSERT INTO log(toolname,user_name,rentaldate,company_password,rentalstate) VALUES (?,?,?,?,?)");
            $stmt->execute(array($toolname,$username,$datetime,$company_password,$rentalstate));
        }catch (PDOException $e){
            $errorMassage = 'データベースエラー';
            return $errorMassage;
        }
    }

}