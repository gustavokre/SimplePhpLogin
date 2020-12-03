<?php

    class Register extends User{
        public function __construct($login, $password, $email, $name)
        {
            if(validate::general($login, 'login') && validate::general($password, 'password') && validate::email($email) && validate::general($name, 'name')){
                $this->setLogin($login);
                $this->setPasswordHash($this->generatePasswordHash($password));
                $this->setEmail($email);
                $this->setFullName($name);
            }
            
        }
    }

?>