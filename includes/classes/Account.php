<?php

class Account {

    private $connect;
    private $errorArray;

    public function __construct($connect) {
        $this->connect = $connect;
        $this->errorArray = array();
    }

    public function login($un, $pw) {
        $pw = md5($pw);
        $query = mysqli_query($this->connect, "SELECT * FROM users WHERE username='$un' AND password='$pw'");
        if(mysqli_num_rows($query) == 1) {
            return true;
        }
        else {
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }
    }

    public function register($un, $em, $pw, $pw2) {
        $this->validateUsername($un);
        $this->validateEmails($em);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {

            return $this->insertUser($un, $em, $pw);
        } else {
            return false;
        }
    }

    public function getError ($error) {
        if(!in_array($error, $this->errorArray)) {
            $error = "";
        }
        return "<span class='errorMessage'>$error</span>";
    }

    private function insertUser($un, $em, $pw) {
        $pw = md5($pw);
        $date = date("Y-m-d");

        $result = mysqli_query($this->connect, "INSERT INTO users VALUES ('', '$un', '$em', '$pw', '$date')");

        return $result;
    }

    private function validateUsername($un) {

        if (strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $checkUsernameQuery = mysqli_query($this->connect, "SELECT username FROM users WHERE username='$un'");
        if(mysqli_num_rows($checkUsernameQuery) != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }

    }

    private function validateEmails($em) {

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $checkEmailQuery = mysqli_query($this->connect, "SELECT email FROM users WHERE email='$em'");
        if(mysqli_num_rows($checkEmailQuery) != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }

    }

    private function validatePasswords($pw, $pw2) {
        if($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if(preg_match('/[^A-Za-z0-9]/', $pw)) {
            array_push($this->errorArray, Constants::$passwordNotAlphaNumeric);
            return;
        }

        if(strlen($pw) > 30 || strlen($pw) < 5) {
            array_push($this->errorArray, Constants::$passwordCharacters);
            return;
        }
    }

}
?>
