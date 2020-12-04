<?php
    class Login extends User{
        private $errors = [];
        private $online = false;
        
        public function __construct($login, $password)
        {
            if(Validate::generic($login, 'login')){
                $this->setLogin($login);
                $this->setPasswordHash($this->generatePasswordHash($password));
            }
        }

        public function getIsOnline(){
            return $this->online;
        }

        public function goOnline(PDO $pdo){
            $stmt = $pdo->prepare("SELECT * FROM user WHERE userLogin=:userLogin and password_hash=:passwordHash");
			$stmt->bindParam(':userLogin', $this->getLogin(), PDO::PARAM_STR);
            $stmt->bindParam(':passwordHash', $this->getPasswordHash(), PDO::PARAM_STR);
            if(!$stmt->execute()) {
                array_push($this->errors, $stmt->errorInfo());
                return false;
            }
            while($user = $stmt->fetch(PDO::FETCH_ASSOC)){
                $this->setEmail($user['email']);
                $this->setFullName($user['fullName']);
                $this->online = true;
                return true;
            }
        }
    }
?>