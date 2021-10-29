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

    class signup extends DataBase{

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
            if(!$data["merchant_name"]=="" && !$data["merchant_email"] =="" && !$data["merchant_password"]=="" && !$data["merchant_card"] =="" && !$data["merchant_cvc"]=="" && !$data["merchant_credit"]=="")
            {
                if(!$obj->name_validate($data["merchant_name"]))  { $check=false; }   // validating name                                                            
                if(!$obj->email_validate($data["merchant_email"]))  { $check=false; }   // validating email                                           
                if(!$obj->password_validate($data["merchant_password"]))  { $check=false; }  // validating password
                if(!$obj->Card_NO_Validate($data["merchant_card"]))    { $check=false; } // validat card no
                if(!$obj->CVC_Validate($data["merchant_cvc"]))    { $check=false; } // validat cvc
                if(!$obj->Credit_Validate($data["merchant_credit"]))    { $check=false; } // validat credit
                return $check;
            }
            else{
                echo json_encode(array('Message'=>'Please fill important field :','status'=>"201"));
                return $check;
            }
           
            
        }
        function insert_data_in_merchants($data)
        {
            if(self::search_merchent_by_email("Merchent",$data["merchant_email"])) //checking whether user already exists or not
            {
                echo json_encode(array('Message'=>'Merchant Already Exist ','status'=>"409"));  //status code 409 because user data added successfuly
            }
            else{
                echo json_encode(array('Message'=>'SignUp Successfully  :','status'=>"201"));  //status code 201 because user data added successfuly
                return self::insert_in_merchants($data);  //insert data for new user
            }
            
        }

        function insert_data_in_cards($data, $merchant_id)
        {
            if(self::search_merchent_by_card("Card",$data["merchant_card"])) //checking whether user already exists or not
            {
                echo json_encode(array('Message'=>'Card Already Exist ','status'=>"409"));  //status code 409 because user data added successfuly
            }
            else{
                self::insert_in_cards($data, $merchant_id);  //insert data of card
                echo json_encode(array('Message'=>'card enter :','status'=>"201"));  //status code 201 because user data added successfuly
           
            }
        }

    }
    $obj = new signup();  
    $p=$obj->get_data();
    if($obj->check_data($p)){
        $merchant_id = $obj->insert_data_in_merchants($p);
        $obj->insert_data_in_cards($p, $merchant_id);
    }
    else{
        echo json_encode(array('Message'=>'InValid Data  Please enter valid data ','status'=>"401"));
    }
?>