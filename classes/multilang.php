<?php
    class MultiLang{
        const LANGUAGE = "ENGLISH";
        const TEXT =
        [
            "PORTUGUESE" =>
            [
                "DB_NO_VALID_CONFIG" => "Nenhuma configuração de database válida!",
                "DB_FILE_NOT_FOUND" => "Arquivo %s não encontrado.",
                "LOGIN_INVALID_INPUT" => "Usuário ou senha não forma preenchidos corretamente.",
                "LOGIN_WRONG_PASSWORD" => "Senha incorreta.",
                "LOGIN_INVALID_USER" => "Usuário não existe",
                "REGISTER_INVALID_INPUT" => "Algum dos campos não foram preenchidos corretamente.",
                "REGISTER_USER_ALREADY_EXIST" => "Usuário já registrado."
            ],
            "ENGLISH" =>
            [
                "DB_NO_VALID_CONFIG" => "No valid database configuration!",
                "DB_FILE_NOT_FOUND" => "File %s not found.",
                "LOGIN_INVALID_INPUT" => "Username or password was not filled in correctly.",
                "LOGIN_WRONG_PASSWORD" => "Wrong password.",
                "LOGIN_INVALID_USER" => "User does not exist",
                "REGISTER_INVALID_INPUT" => "Some of the fields were not filled in correctly.",
                "REGISTER_USER_ALREADY_EXIST" => "User already registered."
            ]
        ];

        public static function getText($key){
            if(!isset(self::TEXT[self::LANGUAGE][$key])){
                throw new Exception("[MultiLang] Invalid Text!");
                return;
            }
            return self::TEXT[self::LANGUAGE][$key];
        }
    }
?>