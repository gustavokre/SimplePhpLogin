<?php
    require_once('../vendor/autoload.php');
    use gustavokre\classes\Session_manager;
    use gustavokre\classes\MultiLang;
    use gustavokre\classes\Database_connection;
    use gustavokre\classes\Validate;
    use gustavokre\classes\User;
    use gustavokre\classes\Login_session;

    $mLangText = 
    [
        "login_help" => sprintf(MultiLang::get_text("REGISTER_LOGIN_HELP"), Validate::INPUTMINSIZE['login'], Validate::INPUTMAXSIZE['login']),
        "password_help" => sprintf(MultiLang::get_text("REGISTER_PASSWORD_HELP"), Validate::INPUTMINSIZE['password']),
    ];

    Session_manager::start();
    $userRR = new Login_session();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Screen</title>
    <link rel="stylesheet" href="css/main.css">
<?php include "head.php";?>
</head>
<body>
    <div class="container">
        <?php include "user_bar.php";?>
        <div class="container-child">
            <!-- Login Container -->
            <div class="container-user" id="c-login">
                <p class="font-o font-size3 text-center"><?php                                          echo MultiLang::get_text("LOGIN_TITLE");?></p>
                <form id="formLogin" action="account/logon.php" method="POST">
                    <input class="userLogin" type="text" name="login" value="" placeholder="Login"><br>
                    <div class="helpField font-t font-size1 invisible"><?php                            echo MultiLang::get_text("LOGIN_HELP")?></div>
                    <input class="userLogin" type="password" name="password" value="" placeholder="Password"><br>
                    <div class="helpField font-t font-size1 invisible"><?php                            echo MultiLang::get_text("PASSWORD_HELP");?></div>
                    <input class="font-size2 font-cor1" type="submit" name="btnLogin" value="<?php      echo MultiLang::get_text("LOGIN_BUTTON");?>">
                </form>
                <span class="font-cor2 font-size1 font-t text-center margin-top-15"><?php               echo MultiLang::get_text("QUESTION_NOT_REGISTRED");?></span><br>
                <span class="font-cor3 font-size2 font-t text-center" id="register-switch"><?php        echo MultiLang::get_text("SUGGESTION_REGISTER");?></span>
            </div>
            <!-- Register Container (this container starts invisible but the user can switch between this and login container)-->
            <div class="container-user display-none" id="c-register">
                <p class="font-o font-size3 text-center"><?php                                          echo MultiLang::get_text("REGISTER_TITLE");?></p>
                <form id="formRegister" action="account/signup.php" method="POST">
                    <input class="userLogin" type="text" name="login" value="" placeholder="Login"><br>
                    <div class="helpField font-t font-size1 invisible"><?php                            echo $mLangText["login_help"];?></div>
                    <input class="userLogin" type="password" name="password" value="" placeholder="Password"><br>
                    <div class="helpField font-t font-size1 invisible"><?php                            echo $mLangText["password_help"];?></div>
                    <input class="userLogin" type="email" name="email" value="" placeholder="Email"><br>
                    <div class="helpField font-t font-size1 invisible"><?php                            echo MultiLang::get_text("REGISTER_HELP_EMAIL");?></div>
                    <input class="userLogin" type="text" name="fullname" value="" placeholder="<?php    echo MultiLang::get_text("REGISTER_NAME_PLACEHOLDER");?>"><br>
                    <div class="helpField font-t font-size1 invisible"><?php                            echo MultiLang::get_text("REGISTER_HELP_NAME");?></div>
                    <input class="font-size2 font-cor1" type="submit" name="btnLogin" value="<?php      echo MultiLang::get_text("REGISTER_BUTTON");?>">
                </form>
                <span class="font-cor2 font-size1 font-t text-center margin-top-15"><?php               echo MultiLang::get_text("QUESTION_ALREADY_REGISTRED");?></span><br>
                <span class="font-cor3 font-size2 font-t text-center" id="login-switch"><?php           echo MultiLang::get_text("SUGGESTION_LOGIN");?></span>
            </div>
        </div>
    </div>
    <script src="js/helpField.js"></script>
    <script src="js/containerSwitch.js"></script>
    <?php if(isset($_GET["error"])){
        echo "<script type='text/javascript'>alert(\"". trim($_SESSION["ERRORS"]) ."\");</script>";
     } ?>
</body>
</html>