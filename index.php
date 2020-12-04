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
        <div class="container-login">
            <p class="font-o font-size3">Login</p>
            <form id="formLogin" action="logon.php" method="POST">
                <input class="userLogin" type="text" name="login" value="" placeholder="Login"><br>
                <input class="userLogin" type="password" name="password" value="" placeholder="Password"><br>
                <input class="font-size2 font-cor1" type="submit" name="btnLogin" value="Fazer login">
            </form>
        </div>
    </div>
</body>
</html>