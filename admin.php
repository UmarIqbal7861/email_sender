<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    header("Content-Type: Application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Methods: post");
    header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Methods,Access-Control-Allow-Headers,Authorization,X-Requested-With');

    require "Validation.php";
    require "DataBase.php";

    class admin extends DataBase{

        public $table_name;
        public $data;

        function get_data(){

            $data=json_decode(file_get_contents("php://input"),true);   //decde input request parameters and store them in an array.
            return $data;
        }
        function check_data($data)
        {
            $obj=new Validate();
            $check = true;
            if(!$obj->name_validate($data["admin_name"]))  { $check=false; }   // validating name                                                            
            if(!$obj->email_validate($data["admin_email"]))  { $check=false; }   // validating email                                           
            return $check;
        }
        function insert_data_in_admin($data)
        {
            if(self::search_admin_by_email("admin",$data["admin_email"])) //checking whether user already exists or not
            {
                echo json_encode(array('Message'=>'admin Already Exist ','status'=>"409"));  //status code 409 because user data added successfuly
            }
            else{
                echo json_encode(array('Message'=>'admin add  :','status'=>"201"));  //status code 201 because user data added successfuly
                self::insert_in_admin($data);  //insert data for new user
            }
            
        }
    }
    $obj = new admin();  
    $p=$obj->get_data();
    if($obj->check_data($p)){
        $obj->insert_data_in_admin($p);
    }
    else{
        echo json_encode(array('Message'=>'InValid Data  Please enter valid data ','status'=>"401"));
    }
?>