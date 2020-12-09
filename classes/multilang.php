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
                "REGISTER_USER_ALREADY_EXIST" => "Usuário já registrado.",
                "INDEX_LOGIN_BUTTON" => "Fazer Login",
                "INDEX_LOGIN_HELP_FIELD" => "%s a %s Letras e números",
                "INDEX_PASSWORD_HELP_FIELD" => "No mínimo %s caracteres"
            ],
            "ENGLISH" =>
            [
                "DB_NO_VALID_CONFIG" => "No valid database configuration!",
                "DB_FILE_NOT_FOUND" => "File %s not found.",
                "LOGIN_INVALID_INPUT" => "Username or password was not filled in correctly.",
                "LOGIN_WRONG_PASSWORD" => "Wrong password.",
                "LOGIN_INVALID_USER" => "User does not exist",
                "REGISTER_INVALID_INPUT" => "Some of the fields were not filled in correctly.",
                "REGISTER_USER_ALREADY_EXIST" => "User already registered.",
                "INDEX_LOGIN_BUTTON" => "Sign in",
                "INDEX_LOGIN_HELP_FIELD" => "%s to %s Letters and numbers",
                "INDEX_PASSWORD_HELP_FIELD" => "At least %s characters"
            ]
        ];

        public static function getText($key){
            if(!isset(self::TEXT[self::LANGUAGE][$key])){
                return "[MultiLang] Invalid Text!: '$key' ";
            }
            return self::TEXT[self::LANGUAGE][$key];
        }
    }
?>