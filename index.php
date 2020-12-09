<?php
    require_once("classes/multilang.php");
    require_once("classes/validate.php");
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
        <div class="container-login" id="c-login">
            <p class="font-o font-size3 text-center">Login</p>
            <form id="formLogin" action="logon.php" method="POST">
                <input class="userLogin" type="text" name="login" value="" placeholder="Login"><br>
                <div class="helpField font-t font-size1 invisible"><?php echo sprintf(MultiLang::getText("INDEX_LOGIN_HELP_FIELD"), Validate::INPUTMINSIZE['login'], Validate::INPUTMAXSIZE['login']);?></div>
                <input class="userLogin" type="password" name="password" value="" placeholder="Password"><br>
                <div class="helpField font-t font-size1 invisible"><?php echo sprintf(MultiLang::getText("INDEX_PASSWORD_HELP_FIELD"), Validate::INPUTMINSIZE['password']);?></div>
                <input class="font-size2 font-cor1" type="submit" name="btnLogin" value=<?php echo MultiLang::getText("INDEX_LOGIN_BUTTON");?>>
            </form>
        </div>
    </div>
    <script src="js/helpField.js"></script>
</body>
</html>