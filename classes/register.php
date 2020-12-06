<?php

    class Register extends User{
        private $errors = [];
        private $valid;

        public function __construct($login, $password, $email, $name)
        {
            if(Validate::generic($login, 'login') && Validate::generic($password, 'password') && Validate::email($email) && Validate::generic($name, 'name')){
                $this->setLogin($login);
                $this->setPasswordHash($this->generatePasswordHash($password));
                $this->setEmail($email);
                $this->setFullName($name);
                $this->valid = true;
            }
            else
            {
                $this->valid = false;
                array_push($this->errors, MultiLang::getText("REGISTER_INVALID_INPUT"));
            }
            
        }

        public function register(PDO $pdo){
            if(!$this->valid || !$this->isLoginAvailable($pdo)){
                return false;
            }
            $table = DatabaseConection::TABLENAME;
            $stmt = $pdo->prepare("INSERT INTO $table (userLogin, password_hash, email, fullName) VALUES(:userLogin,:passwordHash,:email,:fullName)");
			$stmt->bindValue(':userLogin', $this->getLogin(), PDO::PARAM_STR);
            $stmt->bindValue(':passwordHash', $this->getPasswordHash(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':fullName', $this->getFullName(), PDO::PARAM_STR);
            if(!$stmt->execute()) {
                array_push($this->errors, $stmt->errorInfo());
                return false;
            }
            return true;
        }

        public function isLoginAvailable(PDO $pdo){
            $table = DatabaseConection::TABLENAME;
            $stmt = $pdo->prepare("SELECT userLogin FROM $table WHERE userLogin=:userLogin");
			$stmt->bindValue(':userLogin', $this->getLogin(), PDO::PARAM_STR);
            $stmt->bindValue(':passwordHash', $this->getPasswordHash(), PDO::PARAM_STR);
            if(!$stmt->execute()) {
                array_push($this->errors, $stmt->errorInfo());
                return false;
            }
            if($stmt->rowCount() > 0){
                array_push($this->errors, MultiLang::getText("REGISTER_USER_ALREADY_EXIST"));
                return false;
            }
            return true;
        }

    }

?>