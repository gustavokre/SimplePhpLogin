<?php
namespace gustavokre\classes;

class Session_manager{

	//COOKIE_USER_LIFE life time in minutes
	const COOKIE_USER_LIFE = 1440;
	//Session regenerate delay in minutes (after this time the session will be regenerated)
	const SESSION_REGENERATE_DELAY = 15;
	//Session life time in minutes (after this time the user will be forced to log out)
	const SESSION_LIFE = 1440;

	const SALT = "1992";
	
	//reset the attempts after (const value) minutes
	const ATTEMPTS_SAFE_INTERVAL = 3;
	//max attempts (if user attempts is equal or higher he will be blocked from login)
	const MAX_ATTEMPTS = 6;

	public static function start(){
		//for security reasons
		ini_set('session.cookie_httponly', 1);
		ini_set('session.use_only_cookies', 1);

		session_start();
		self::set_cookie();

		if(self::is_life_end()){
			self::go_offline();
		}

		if(self::need_regenerate() && self::is_valid_session()){
			self::regenerate();
		}
	}

	public static function set_cookie(){
		setcookie(session_name(),session_id(), time() + (self::COOKIE_USER_LIFE*60), "/");
	}

	private static function register_new_hash(){
		$_SESSION['HASH'] = self::generate_hash();
    }
    
	private static function generate_hash(){
		return md5(self::SALT . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
	}

	public static function save_login(login $user){
		if(self::is_destroyed()) self::regenerate();
		self::register_new_hash();
		$_SESSION['ONLINE'] = true;
		$_SESSION['FULLNAME'] = $user->get_full_name();
		$_SESSION['EMAIL'] = $user->get_email();
		$_SESSION['USER'] = $user->get_login();
		$_SESSION['JOIN_DATE'] = $user->get_join_date();
		$_SESSION['LOGIN_TIME'] = time();
		$_SESSION['EXPIRES'] = time() + (self::SESSION_REGENERATE_DELAY*60);
		/*i think is important dont change the $_SESSION['ATTEMPTS'] value, for example:
		if i set to 0, it is possible to user brute force login and when is one attempt left
		he do a login into a valid account and the attempts will be set to zero and he can try brute force again
		*/
	}

	public static function go_offline(){
		session_unset();
		session_destroy();
		session_write_close();
	}

	public static function regenerate(){
		$_SESSION['DESTROYED'] = TRUE;
		session_regenerate_id();
		self::set_cookie();
		unset($_SESSION['DESTROYED']);
		$_SESSION['EXPIRES'] = time() + (self::SESSION_REGENERATE_DELAY*60);
	}
	
	//check if session needs to be regenerated
	public static function need_regenerate(){
		if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()){
			return true;
		}
		return false;
	}

	public static function get_is_online(){
		if(isset($_SESSION['ONLINE']) && $_SESSION['ONLINE'] === true && self::is_valid_session()){
			return true;
		}
		return false;
	}

	public static function is_life_end(){
		if(!isset($_SESSION['LOGIN_TIME'])) return false;
		$current_life = time() - $_SESSION['LOGIN_TIME'];
		if($current_life > (self::SESSION_LIFE * 60)){
			return true;
		}
		return false;
	}

	public static function is_destroyed(){
		if(isset($_SESSION['DESTROYED']) && $_SESSION['DESTROYED']){
			return true;
		}
		return false;
	}

	public static function is_valid_session(){
		if(!isset($_SESSION['HASH']) || isset($_SESSION['DESTROYED'])){
			return false;
		}
		$currentID = self::generate_hash();
		if($currentID === $_SESSION['HASH']){
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