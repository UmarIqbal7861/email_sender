<?php
    class Validate      //Create validation class to check all the input in correct methord :
    {
        /**
         *email_validate function get one parmeter and check email pattern if pattern match return true else false
         */
        public function Email_Validate($email)                                            
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false; 
            }
            else{
                return true;
            } 
        }
        /**
         * password_validate function get one parmeter and check password pattern if pattern match return true else false
         */
        public function Password_Validate($password)        
        {
            //$password_pattern='/^(?=.*[A-Z]).{8,20}$/';     //password length > 8 , 1 uppercase charecter
            $password_pattern= '/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';     //password length > 8 , 1 uppercase charecter , 1 Numarical number
            if(!preg_match($password_pattern, $password)){  //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
        /**
         *phone_validate function get one parmeter and check phone pattern if pattern match return true else false
         */
        public function Phone_Validate($phone)
        {
            $phone_pattern = "/^(03)+([0-4]{1})+([0-9]{1})[-]([0-9]{7})$/";     //number of total length 11 start 03 and next to digit between 00-49 next 7 digit 0-9
            if(!preg_match($phone_pattern, $phone)){    //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
        /**
         *name_validate function get one parmeter and check name pattern if pattern match return true else false
         */
        public function Name_Validate($name)
        {
            $name_pattern="/^[a-zA-Z ]*$/";     //Not Accept Special character and digit
            if(!preg_match($name_pattern, $name)){      //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
        /**
         *cnic_validate function get one parmeter and check CNIC pattern if pattern match return true else false
         */
        public function Cnic_Validate($cnic)
        {
            $cnic_pattern="/^([0-9]{5})[-]([0-9]{7})[-]([0-9]{1})$/"; //length of CNIC is 13 and first - after 5 digit second - after 7 digit 
            if(!preg_match($cnic_pattern, $cnic)){      //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
        /**
         *Card_NO_Validate function get one parmeter and check card no pattern if pattern match return true else false
         */
        public function Card_NO_Validate($Card)
        {
            $Card_pattern="/^([0-9]{16})$/";  //enter only 16 digit number 
            if(!preg_match($Card_pattern, $Card)){     //check patteren match
                echo "invalid";
                return false;
            }
            else{
                return true;
            }
        }
        /**
         *CVC_Validate function get one parmeter and check cvc pattern if pattern match return true else false
         */
        public function CVC_Validate($CVC)
        {
            $CVC_pattern="/^([0-9]{3})$/";  //enter only 3 digit number 
            if(!preg_match($CVC_pattern, $CVC)){     //check patteren match
                return false;
            }
            else{
                return true;
            }
        }
        /**
         *Date_Validate function get three parmeter and check date pattern if pattern match return true else false
         */
        public function Date_validate($month, $day, $year)
        {
            if(checkdate($month, $day, $year))      //first come month then day then years
            {
                return true;
            }
            else{
                return false;
            }
        }
        /**
         *Credit_Validate function get one parmeter and check  pattern if pattern match return true else false
         */
        public function Credit_Validate($amount)
        {
            $credit_pattern="/^[0-9]{1,20}$/";      // only positive amount enter
            if(!preg_match($credit_pattern, $amount)){  //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
    }
?>
