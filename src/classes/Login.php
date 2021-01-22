<?php
    namespace gustavokre\classes;

    class Login extends User{
        private $online = false;
        private $valid = false;
        private $password;
        private $pdo;
        
        public function __construct($login, $password)
        {
            if(Validate::generic($login, 'login') && Validate::generic($password, 'password')){
                $this->set_login($login);
                $this->password = $password;
                $this->valid = true;
                $this->pdo = Database_connection::get_connection();
            }
            else
            {
                array_push($this->errors, MultiLang::get_text("LOGIN_INVALID_INPUT"));
            }
        }

        public function get_is_onlinene(){
            return $this->online;
        }

        public function goOnline(){
            if(!$this->valid){
                return false;
            }
            $table = Database_connection::TABLENAME;
            $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE userLogin=:userLogin");
            $stmt->bindValue(':userLogin', $this->get_login(), \PDO::PARAM_STR);
            
            if(!$stmt->execute()) {
                array_push($this->errors, $stmt->errorInfo());
                return false;
            }

            while($user = $stmt->fetch(\PDO::FETCH_ASSOC)){
                if($this->verifyPassword($this->password, $user['password_hash'])){
                    $this->set_email($user['email']);
                    $this->set_full_name($user['fullName']);
                    $this->set_join_date($user['joinDate']);
                    $this->online = true;
                    Session_manager::save_login($this);
                    return true;
                }
                array_push($this->errors, MultiLang::get_text("LOGIN_WRONG_PASSWORD"));
                return false;
            }
            array_push($this->errors, MultiLang::get_text("LOGIN_INVALID_USER"));
            return false;
        }

        public function verifyPassword($password, $dbPassword){
            return password_verify($password, $dbPassword);
        }

        public function go_offlinee(){
            $this->unset_all();
            $this->valid = false;
            $this->online = false;
            Session_manager::go_offline();
        }
    }
?>