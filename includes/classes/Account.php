<?php
  class Account {

    private $con;
    private $errorArray;

    public function __construct ($con) {
      $this->con = $con;
      $this->errorArray = array();
    }

    public function login ($un, $pw) {
      $pw = md5($pw);

      $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

      if (mysqli_num_rows($query) == 1) {
        return true;
      } else {
        array_push($this->errorArray, Constants::$loginFailed);
        return false;
      }
    }

    public function register ($un, $fn, $ln, $em, $em2, $pw, $pw2) {
      $this->validateUsername($un);
      $this->validateFirstname($fn);
      $this->validateLastname($ln);
      $this->validateEmails($em, $em2);
      $this->validatePasswords($pw, $pw2);

      if (empty($this->errorArray)) {
        //Insert into DB
        return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
      } else {
        return false;
      }
    }

    public function getError ($error) {
      if (!in_array($error, $this->errorArray)) {
        $error = "";
      }
      return "<span class='errorMessage'>$error</span>";
    }

    private function insertUserDetails ($un, $fn, $ln, $em, $pw) {
      $encryptedPw = md5($pw); // md5 function for encription
      $profilePic = "assets/images/profile-pics/profile-pic-placeholder.png";
      $date = date("Y-m-d");

      // Must have single quotes around query parameters, otherwise it will throw error
      // Default example is not working because empty value for id column causes an error, type is string but should be int
      // $result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");
      // Need to omit id from the column list and values when inserting records, because it has an AUTO_INCREMENT
      $result = mysqli_query($this->con, "INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic) VALUES ('$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");
      return $result;
    }

    private function validateUsername ($un) {
      
      if (strlen($un) > 25 || strlen($un) < 5) {
        array_push($this->errorArray, Constants::$userNameCharacters);
        return;
      }

      $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
      if (mysqli_num_rows($checkUsernameQuery) != 0) {
        array_push($this->errorArray, Constants::$usernameTaken);
        return;
      }

    }
    
    private function validateFirstname ($fn) {
      if (strlen($fn) > 25 || strlen($fn) < 2) {
        array_push($this->errorArray, Constants::$firstNameCharacters);
        return;
      }
    }
    
    private function validateLastname ($ln) {
      if (strlen($ln) > 25 || strlen($ln) < 2) {
        array_push($this->errorArray, Constants::$lastNameCharacters);
        return;
      }
    }
    
    private function validateEmails ($em, $em2) {
      if ($em != $em2) {
        array_push($this->errorArray, Constants::$emailsDoNotMatch);
        return;
      }

      if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
        array_push($this->errorArray, Constants::$emailInvalid);
        return;
      }

      $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
      if (mysqli_num_rows($checkEmailQuery) != 0) {
        array_push($this->errorArray, Constants::$emailTaken);
        return;
      }
    
    }
    
    private function validatePasswords ($pw, $pw2) {
      if ($pw != $pw2) {
        array_push($this->errorArray, Constants::$passwordsDoNotMatch);
        return;
      }

      if (preg_match('/[^A-Za-z0-9]/', $pw)) {
        array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
        return;
      }

      if (strlen($pw) > 30 || strlen($pw) < 5) {
        array_push($this->errorArray, Constants::$passwordCharachters);
        return;
      }
    }

  }
?>