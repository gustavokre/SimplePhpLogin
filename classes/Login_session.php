<?php 
    class Login_session extends User{

        private $online = false;
        //time in minutes (14400 = 10 days)
        const MAX_MINUTES_SESSION_LOGIN = 14400;

        public function go_online(){
            if(Session_manager::get_is_online()){
                $sessionMinutesLife = (time() - $_SESSION['LOGIN_TIME']) / 60;
                if($sessionMinutesLife > self::MAX_MINUTES_SESSION_LOGIN) return false;
                $this->set_full_name($_SESSION['FULLNAME']);
                $this->set_email($_SESSION['EMAIL']);
                $this->set_login($_SESSION['USER']);
                $this->online = true;
                return true;
            }
            return false;
        }

        public function get_is_online(){
            return $this->online;
        }

        public function go_offline(){
            $this->unset_all();
            $this->online = false;
            Session_manager::go_offline();
        }
}

?>