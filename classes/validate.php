<?php

class validate{

	//estes valores devem ser de acordo com o banco de dados (cuidado);
	const INPUTMAXSIZE = [
		'login' => 21,
		'name' => 64,
		'password' => 32
	];

	const INPUTMINSIZE = [
		'login' => 4,
		'name' => 3,
		'password' => 6
	];

	const rege = [
		'login' => "/^[a-zA-Z0-9]+$/",
		'name' => "/^[a-záàâãéèêíïóôõöúçñ ]+$/i",
		'password' => "/^.*$/i"
	];

	public static function general($input, $type){
		if(!isset(self::rege[$type]) || !isset(self::INPUTMINSIZE[$type]) || !isset(self::INPUTMAXSIZE[$type])) return false;

		$len = strlen($input);
		if($len < self::INPUTMINSIZE[$type] || $len > self::INPUTMAXSIZE[$type]) return false;
		/*
		Aplica o regex no input, se o resultado for diferente do input
		quer dizer que existe algum caractere nao permitido dentro do proprio input
		consequentemente sera retornado false (nao foi validado)
		*/
		preg_match(self::rege[$type], $input, $result);
		if($result[0] == $input){
			return true;
		}
		return false;
    }
    
		public static function email($email){
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return true;
			}
			return false;
		}
}

?>