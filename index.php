<?php
    require_once("classes/multilang.php");
    require_once("classes/validate.php");
    
    $mLangText = 
    [
        "login_help" => sprintf(MultiLang::getText("REGISTER_LOGIN_HELP"), Validate::INPUTMINSIZE['login'], Validate::INPUTMAXSIZE['login']),
        "password_help" => sprintf(MultiLang::getText("REGISTER_PASSWORD_HELP"), Validate::INPUTMINSIZE['password']),
    ];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Screen</title>
<?php include "head.php";?>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/fontes.css">
</head>
<body>
    <div class="container">
        <!-- Login Container -->
        <div class="container-user" id="c-login">
            <p class="font-o font-size3 text-center"><?php                                          echo MultiLang::getText("LOGIN_TITLE");?></p>
            <form id="formLogin" action="logon.php" method="POST">
                <input class="userLogin" type="text" name="login" value="" placeholder="Login"><br>
                <div class="helpField font-t font-size1 invisible"><?php                            echo MultiLang::getText("LOGIN_HELP")?></div>
                <input class="userLogin" type="password" name="password" value="" placeholder="Password"><br>
                <div class="helpField font-t font-size1 invisible"><?php                            echo MultiLang::getText("PASSWORD_HELP");?></div>
                <input class="font-size2 font-cor1" type="submit" name="btnLogin" value="<?php      echo MultiLang::getText("LOGIN_BUTTON");?>">
            </form>
            <span class="font-cor2 font-size1 font-t text-center margin-top-15"><?php               echo MultiLang::getText("QUESTION_NOT_REGISTRED");?></span><br>
            <span class="font-cor3 font-size2 font-t text-center" id="register-switch"><?php        echo MultiLang::getText("SUGGESTION_REGISTER");?></span>
        </div>
        <!-- Register Container (this container starts invisible but the user can switch between this and login container)-->
        <div class="container-user display-none" id="c-register">
            <p class="font-o font-size3 text-center"><?php                                          echo MultiLang::getText("REGISTER_TITLE");?></p>
            <form id="formRegister" action="signup.php" method="POST">
                <input class="userLogin" type="text" name="login" value="" placeholder="Login"><br>
                <div class="helpField font-t font-size1 invisible"><?php                            echo $mLangText["login_help"];?></div>
                <input class="userLogin" type="password" name="password" value="" placeholder="Password"><br>
                <div class="helpField font-t font-size1 invisible"><?php                            echo $mLangText["password_help"];?></div>
                <input class="userLogin" type="email" name="email" value="" placeholder="Email"><br>
                <div class="helpField font-t font-size1 invisible"><?php                            echo MultiLang::getText("REGISTER_HELP_EMAIL");?></div>
                <input class="userLogin" type="text" name="fullname" value="" placeholder="<?php    echo MultiLang::getText("REGISTER_NAME_PLACEHOLDER");?>"><br>
                <div class="helpField font-t font-size1 invisible"><?php                            echo MultiLang::getText("REGISTER_HELP_NAME");?></div>
                <input class="font-size2 font-cor1" type="submit" name="btnLogin" value="<?php      echo MultiLang::getText("REGISTER_BUTTON");?>">
            </form>
            <span class="font-cor2 font-size1 font-t text-center margin-top-15"><?php               echo MultiLang::getText("QUESTION_ALREADY_REGISTRED");?></span><br>
            <span class="font-cor3 font-size2 font-t text-center" id="login-switch"><?php           echo MultiLang::getText("SUGGESTION_LOGIN");?></span>
        </div>
    </div>
    <script src="js/helpField.js"></script>
    <script src="js/containerSwitch.js"></script>
</body>
</html>