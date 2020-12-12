<?php
    class MultiLang{
        const LANGUAGE = "PORTUGUESE";
        const TEXT =
        [
            "PORTUGUESE" =>
            [
                "DB_NO_VALID_CONFIG" => "Nenhuma configuração de database válida!",
                "DB_FILE_NOT_FOUND" => "Arquivo %s não encontrado.",
                "LOGIN_INVALID_INPUT" => "Usuário ou senha não forma preenchidos corretamente.",
                "LOGIN_WRONG_PASSWORD" => "Senha incorreta.",
                "LOGIN_INVALID_USER" => "Usuário não existe",        
                "LOGIN_BUTTON" => "Fazer Login",
                "LOGIN_HELP" => "Digite o nome do seu usuário",
                "LOGIN_TITLE" => "Faça seu Login",
                "PASSWORD_HELP" => "Digite sua senha",
                "REGISTER_PASSWORD_HELP" => "No mínimo %s caracteres",
                "REGISTER_LOGIN_HELP" => "%s a %s Letras, números e _",
                "REGISTER_INVALID_INPUT" => "Algum dos campos não foram preenchidos corretamente.",
                "REGISTER_USER_ALREADY_EXIST" => "Usuário já registrado.",
                "REGISTER_TITLE" => "Registrar",
                "REGISTER_HELP_EMAIL" => "Digite o seu endereço de e-mail",
                "REGISTER_NAME_PLACEHOLDER" => "Nome completo",
                "REGISTER_HELP_NAME" => "Digite o seu nome completo",
                "REGISTER_BUTTON" => "Cadastrar",
                "QUESTION_ALREADY_REGISTRED" => "Já é Cadastrado?",
                "QUESTION_NOT_REGISTRED" => "Não é Cadastrado?",
                "SUGGESTION_LOGIN" => "Login",
                "SUGGESTION_REGISTER" => "Cadastrar"
            ],
            "ENGLISH" =>
            [
                "DB_NO_VALID_CONFIG" => "No valid database configuration!",
                "DB_FILE_NOT_FOUND" => "File %s not found.",
                "LOGIN_INVALID_INPUT" => "Username or password was not filled in correctly.",
                "LOGIN_WRONG_PASSWORD" => "Wrong password.",
                "LOGIN_INVALID_USER" => "User does not exist",
                "LOGIN_BUTTON" => "Sign in",
                "LOGIN_HELP" => "Enter your username",
                "LOGIN_TITLE" => "Log in",
                "PASSWORD_HELP" => "Enter your password",
                "REGISTER_PASSWORD_HELP" => "At least %s characters",
                "REGISTER_LOGIN_HELP" => "%s to %s Letters, numbers, _",
                "REGISTER_INVALID_INPUT" => "Some of the fields were not filled in correctly.",
                "REGISTER_USER_ALREADY_EXIST" => "User already registered.",
                "REGISTER_TITLE" => "Sign up",
                "REGISTER_HELP_EMAIL" => "Enter your e-mail address",
                "REGISTER_NAME_PLACEHOLDER" => "Full name",
                "REGISTER_HELP_NAME" => "Enter your full name",
                "REGISTER_BUTTON" => "Register",
                "QUESTION_ALREADY_REGISTRED" => "Already Registred?",
                "QUESTION_NOT_REGISTRED" => "Not Registred?",
                "SUGGESTION_LOGIN" => "Login",
                "SUGGESTION_REGISTER" => "Create an Account"
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