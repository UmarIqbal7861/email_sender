<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'jwthandler.php';
class Database{
    private $servername = "localhost";
    private $username = "root";
    private $password = "MUHammad786";
    private $dbname = "sender_email";

    public function build_connection(){     //build sql database connection 
        
        $conn = new mysqli($this->servername,$this->username,$this->password,$this->dbname);
        if ($conn->connect_error){
            echo "Database Connection Error";
        }
        else{
            //echo "connect";
            return $conn;
        }
        
    }
    private function close_connection($conn){   //close database connection
        $conn->close();
    }
    function insert_in_merchants($d){

        $innerPera = "Merchant_Name,Email,M_Password,Image";
        $merchant_name = $d["merchant_name"];
        $merchant_email = $d["merchant_email"];
        $merchant_password = $d["merchant_password"];
        $image = $d["image"];
        $conn = self::build_connection();
        $q1 = "insert into Merchent($innerPera) values('{$merchant_name}','{$merchant_email}','{$merchant_password}','{$image}')";
        $conn->query($q1);  
        $merchant_id = $conn->insert_id;
        self::close_connection($conn);   
        return $merchant_id;
    }
    function insert_in_admin($d){

        $innerPera = "Name,email";
        $admin_name = $d["admin_name"];
        $adminant_email = $d["admin_email"];
        $conn = self::build_connection();
        $q1 = "insert into admin($innerPera) values('{$admin_name}','{$adminant_email}')";
        $conn->query($q1);  
        self::close_connection($conn);   
    }
    function insert_in_cards($d, $merchant_id){
        $innerPera = "Card_No,credit,cvc,valid_from,valid_through,M_id";
        $card_no=$d["merchant_card"];
        $credit=$d["merchant_credit"];
        $cvc=$d["merchant_cvc"];
        $valid_from=$d["valid_from"];
        $valid_through=$d["valid_through"];
        $conn = self::build_connection();       
        $q3 = "insert into card($innerPera) values('{$card_no}','{$credit}','{$cvc}','{$valid_from}','{$valid_through}','{$merchant_id}')"; 
        $conn->query($q3);

        self::close_connection($conn);
    }
    function search_merchent_by_email($tableName,$email)        // searching merchant by email
    {

        $conn = self::build_connection();
        $q = "select * from ".$tableName ." WHERE Email='{$email}'";
        $result = $conn->query($q);
        self::close_connection($conn);
        if($result->num_rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    function search_admin_by_email($tableName,$email)        // searching merchant by email
    {

        $conn = self::build_connection();
        $q = "select * from ".$tableName ." WHERE email='{$email}'";
        $result = $conn->query($q);
        self::close_connection($conn);
        if($result->num_rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    function search_merchent_by_card($tableName,$card)        // searching merchant by email
    {

        $conn = self::build_connection();
        $q = "select * from ".$tableName ." WHERE Card_No='{$card}'";
        $result = $conn->query($q);
        self::close_connection($conn);
        if($result->num_rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    function merchant_login($data)
    {
       $conn = self::build_connection();
       $email=$data["email"];
       $password=$data["password"];
       $query = "SELECT * FROM  Merchent WHERE M_Password = '{$password}' AND  Email='{$email}'";
       //sql query to check Password and email is present in databse 
       $result = $conn->query($query) or die("SQL QUERY FAIL.");
       if($result->num_rows > 0)  { $data = $result->fetch_all(MYSQLI_ASSOC);
       
           $jwt = new JWT($email);
           $token = $jwt->Generate_jwt();
           $q="UPDATE Merchent SET token = '{$token}' WHERE Email='{$email}' ";
           $q1="UPDATE Merchent SET status = 1 WHERE Email='{$email}'";
           $q2="UPDATE Merchent SET create_time = current_timestamp() WHERE Email='{$email}'";
           $q3="UPDATE Merchent SET M_current_time = current_timestamp() WHERE Email='{$email}'";

           $result = $conn->query($q3) or die("SQL  QUERY FAIL for current .");
           $result = $conn->query($q2) or die("SQL  QUERY FAIL for create .");
           $result = $conn->query($q1) or die("SQL  QUERY FAIL for status .");
           $result = $conn->query($q) or die("SQL  QUERY FAIL for adding token .");
           return true;
       }
       else{
           return false;
       }
    }

}
?>