<?php
    namespace gustavokre\classes;

    abstract class User{
        protected $errors = [];
        private $login;
        private $passwordHash;
        private $firstName;
        private $fullName;
        private $email;
        private $joinDate;

        public function get_errors(){
            return $this->errors;
        }

        public function get_password_hash(){
            return $this->passwordHash;
        }

        public function get_login(){
            return $this->login;
        }

        public function get_full_name(){
            return $this->fullName;
        }

        public function get_email(){
            return $this->email;
        }

        public function get_first_name(){
            return $this->firstName;
        }

        public function get_join_date(){
            return $this->joinDate;
        }

        public function set_first_name($firstName){
            $this->firstName = $firstName;
        }
        public function set_full_name($fullName){
            $this->fullName = $fullName;
        }
        public function set_email($email){
            $this->email = $email;
        }

        public function set_login($login){
            $this->login = $login;
        }

        public function set_join_date($date){
            $this->joinDate = $date;
        }

        public function set_password_hash($hash){
            $this->passwordHash = $hash;
        }

        public function generate_password_hash($password){
            return password_hash($password, PASSWORD_BCRYPT); 
        }

        public function unset_all(){
            $this->errors = [];
            $this->login = "";
            $this->passwordHash = "";
            $this->firstName = "";
            $this->fullName = "";
            $this->email = "";
        }
    }

?>