<?php

    abstract class User{
        private $login;
        private $passwordHash;
        private $firstName;
        private $fullName;
        private $email;

        public function getPasswordHash(){
            return $this->passwordHash;
        }

        public function getLogin(){
            return $this->login;
        }

        public function getFullName(){
            return $this->fullName;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getFirstName(){
            return $this->firstName;
        }

        public function setFirstName($firstName){
            $this->firstName = $firstName;
        }
        public function setFullName($fullName){
            $this->fullName = $fullName;
        }
        public function setEmail($email){
            $this->email = $email;
        }

        public function setLogin($login){
            $this->login = $login;
        }

        public function setPasswordHash($hash){
            $this->passwordHash = $hash;
        }

        public function generatePasswordHash($password){
            return password_hash($password, PASSWORD_BCRYPT); 
        }
    }

?>