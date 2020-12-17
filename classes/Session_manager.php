<?php

class Session_manager{
	/*
	importante usar no php.ini
	session.cookie_httponly 1
	*/

	//expirar em quantos minutos a sessao
	const EXPIRAR = 5;

	const SALT = "1992";
	const MAX_ATTEMPTS = 6;
	//reset the attempts after (const value) minutes
	const ATTEMPTS_SAFE_INTERVAL = 3;

	public static function start(){
		session_start();
		//with this line every time the user's load a page 
		setcookie(session_name(),session_id(), time() + (self::EXPIRAR*60));
		self::check_expired();
	}

	public static function get_is_online(){
		if(isset($_SESSION['ONLINE']) && $_SESSION['ONLINE'] === true && self::is_valid_session_id()){
			return true;
		}
		return false;
	}

	private static function register_new_id(){
		$_SESSION['ID'] = self::generate_id();
    }
    
    private static function generate_id(){
        return md5(self::SALT . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
    }

	public static function save_login(login $user){
		self::register_new_id(self::generate_id());
		$_SESSION['ONLINE'] = true;
		$_SESSION['FULLNAME'] = $user->get_full_name();
		$_SESSION['EMAIL'] = $user->get_email();
		$_SESSION['USER'] = $user->get_login();
		$_SESSION['LOGIN_TIME'] = time();
		$_SESSION['EXPIRES'] = time() + (self::EXPIRAR*60);
		/*i think is important dont change the $_SESSION['ATTEMPTS'] value, for example:
		if i set to 0, it is possible to user brute force login and when is one attempt left
		he do a login into a valid account and the attempts will be set to zero and he can try brute force again
		*/
	}

	public static function regenerate(){
		session_regenerate_id();
		$_SESSION['EXPIRES'] = time() + (self::EXPIRAR*60);
	}

	/**
	* regenerate session id if expired
	 */
	public static function check_expired(){
		if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()){
			self::regenerate();
			return true;
		}
		return false;
	}

	public static function go_offline(){
		session_unset();
		session_destroy();
		session_write_close();
	}

	public static function is_valid_session_id(){
		if(!isset($_SESSION['ID'])){
			return false;
		}
		$currentID = self::generate_id();
		if($currentID === $_SESSION['ID']){
			return true;
		}
		return false;
	}

	public static function failed_login(){
		if(!isset($_SESSION['ATTEMPTS'])){
			$_SESSION['ATTEMPTS'] = 1;
			$_SESSION['LAST_ATTEMPT'] = time();
			return 0;
		}

		if(((time() - $_SESSION['LAST_ATTEMPT']) /60) >= self::ATTEMPTS_SAFE_INTERVAL){
			$_SESSION['ATTEMPTS'] = 1;
			$_SESSION['LAST_ATTEMPT'] = time();
			return 0;
		}
		$_SESSION['ATTEMPTS']++;
		$_SESSION['LAST_ATTEMPT'] = time();
	}

	public function is_blocked(){
		if(!isset($_SESSION['ATTEMPTS'])){
			return false;
		}
		if($_SESSION['ATTEMPTS'] > self::MAX_ATTEMPTS){
			if(((time() - $_SESSION['LAST_ATTEMPT']) /60) >= self::ATTEMPTS_SAFE_INTERVAL){
				return false;
			}
			return true;
		}
		return false;
	}
}

?>