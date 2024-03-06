<?php 

    class Account {

        private $conn;
        private $errorArray;

        public function __construct($conn) 
        {
            $this->conn = $conn;
            $this->errorArray = array();
        }

        public function login($un, $pw) {
            $pw = md5($pw);
            
            $query = mysqli_query($this->conn, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

            if(mysqli_num_rows($query) == 1) {
                return true;
            }else {
                array_push($this->errorArray, Constants::$loginFail);
                return false;
            }
            
            
        }


        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
            
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray) == true){
                // Insert into db
				return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
            }
            else{
                return false;
            }
        }


        public function getError($error) 
        {
            if(!in_array($error, $this->errorArray)) {
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        private function insertUserDetails($un, $fn, $ln, $em, $pw) {
			$encryptedPw = md5($pw);
			$profilePic = "assets/images/profile-pics/head_emerald.png";
			$date = date("Y-m-d");

			$result = mysqli_query($this->conn, "INSERT INTO users VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");

			return $result;
		}


        private function validateUsername($un) 
        {
            
            if(strlen($un) > 25 || strlen($un) < 5) {
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }
            //TODO: check if username exists
            $checkUsernameQuery = mysqli_query($this->conn, "SELECT username FROM users WHERE username='$un'");
            iF(mysqli_num_rows($checkUsernameQuery) != 0){
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
        }

        private function validateFirstName($fn) 
        {
            if(strlen($fn) > 25 || strlen($fn) < 2) {
                array_push($this->errorArray, Constants::$firstNameCharacters);
                return;
            }
        }

        private function validateLastName($ln) 
        {
            if(strlen($ln) > 25 || strlen($ln) < 2) {
                array_push($this->errorArray, Constants::$lastNameCharacters);
                return;
            }
        }

        private function validateEmails($em, $em2) 
        {
            if($em != $em2){
                array_push($this->errorArray, Constants::$emailsDoNotMatch);
                return;
            }

            if(!filter_var($em, FILTER_SANITIZE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }

            // TODO: Check that username hasn;t already used
            $checkEmailQuery = mysqli_query($this->conn, "SELECT username FROM users WHERE email='$em'");
            iF(mysqli_num_rows($checkEmailQuery) != 0){
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        }

        private function validatePasswords($pw, $pw2) 
        {
            if($pw != $pw2){
                array_push($this->errorArray, Constants::$passwordsDoNotMatch);
                return;
            }

            if(preg_match('/[^A-Za-z0-9]/', $pw)) {
                array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
                return;
            }

            if(strlen($pw) > 30 || strlen($pw) < 5) {
                array_push($this->errorArray, Constants::$passwordCharacters);
                return;
            }
        }




    }




?>