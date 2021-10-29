<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Database.php';
include 'validation.php';

class LogIn extends DataBase{


    public $data;

/*
*    function to get data
*/
    public function get_data(){
        if($_SERVER["REQUEST_METHOD"] != "POST")//Check if request method is not $_POST send error message and terminate program
        {
            echo json_encode(array('Message'=>'Page not found','status'=>"404"));  //status code 409 because user data added successfuly
            http_response_code(404); 
            exit();
        }
        else{
        $data=json_decode(file_get_contents("php://input"),true);   //decde input request parameters and store them in an array.
        return $data;
        }
    
    }

/*
 
*    function to login og merchant

*/
   public function login_for_merchant($data){

      if( self::merchant_login($data))
      {
        echo json_encode(array('Message'=>'Merchant successfuly login','status'=>"409"));  //status code 409 because user data added successfuly

      }

   }

   public function validating_data($data)
        {
            $v=new Validate();
            $check_all = true;

            if(!$v->email_validate($data["email"]))        { $check_all=false; }            // validating email                                                   
            if(!$v->password_validate($data["password"]))  { $check_all=false; }            // validating password
            return $check_all;
        }

        public function trim_data($data)
        {
            
            $email = trim($data["email"]);
            $password = trim($data["password"]);
            

        }


}


$obj=new LogIn();
$p1=$obj->get_data();

if($obj->validating_data($p1))
{
    $obj->trim_data($p1);
    $obj->login_for_merchant($p1);
}
else{
    echo "hshjbashbdjhasbjfbbasfhfba";
}
   

?>