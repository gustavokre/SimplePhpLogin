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
                array_push($this->errors, "Algum dos campos não foi preenchido corretamente.");
            }
            
        }

        public function register(){
            if(!$this->valid){
                return false;
            }

        }

        public function isLoginInUse(){
            
        }

    }

?>