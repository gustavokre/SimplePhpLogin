<?php
    namespace gustavokre\classes;

    class Register extends User{
        private $valid;
        private $pdo;

        public function __construct($login, $password, $email, $name)
        {
            if(Validate::generic($login, 'login') && Validate::generic($password, 'password') && Validate::email($email) && Validate::generic($name, 'name')){
                $this->pdo = Database_connection::get_connection();
                $this->set_login($login);
                $this->set_password_hash($this->generate_password_hash($password));
                $this->set_email($email);
                $this->set_full_name($name);
                $this->set_join_date(date("Y-m-d"));
                $this->valid = true;
            }
            else
            {
                $this->valid = false;
                array_push($this->errors, MultiLang::get_text("REGISTER_INVALID_INPUT"));
            }
        }

        public function register(){
            if(!$this->valid || !$this->is_login_email_available($this->pdo)){
                return false;
            }
            $table = Database_connection::TABLENAME;
            $stmt = $this->pdo->prepare("INSERT INTO $table (userLogin, password_hash, email, fullName, joinDate) VALUES(:userLogin,:passwordHash,:email,:fullName, CURRENT_DATE())");
			$stmt->bindValue(':userLogin', $this->get_login(), \PDO::PARAM_STR);
            $stmt->bindValue(':passwordHash', $this->get_password_hash(), \PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->get_email(), \PDO::PARAM_STR);
            $stmt->bindValue(':fullName', $this->get_full_name(), \PDO::PARAM_STR);
            if(!$stmt->execute()) {
                array_push($this->errors, $stmt->errorInfo());
                return false;
            }
            return true;
        }

        public function is_login_email_available(){
            $table = Database_connection::TABLENAME;
            $stmt = $this->pdo->prepare("SELECT userLogin FROM $table WHERE userLogin=:uLogin OR email=:uEmail");
            $stmt->bindValue(':uLogin', $this->get_login(), \PDO::PARAM_STR);
            $stmt->bindValue(':uEmail', $this->get_email(), \PDO::PARAM_STR);
            if(!$stmt->execute()) {
                array_push($this->errors, $stmt->errorInfo());
                return false;
            }
            if($stmt->rowCount() > 0){
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                if($user['userLogin'] == $this->get_login())
                    array_push($this->errors, MultiLang::get_text("REGISTER_USER_ALREADY_EXIST"));
                else
                    array_push($this->errors, MultiLang::get_text("REGISTER_EMAIL_ALREADY_EXIST"));
                    
                return false;
            }
            return true;
        }

    }

?>