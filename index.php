<!DOCTYPE html>
<html>
<head>
    <title>Tela de Login</title>
<?php include "head.php";?>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
        <div class="container-login">
            <p class="font-o font-size3">Login</p>
            <form id="formLogin" action="login.php" method="POST">
                <input type="text" name="login" value="" placeholder="Login"><br>
                <input type="password" name="password" value="" placeholder="Password">
                <input type="submit" name="btnLogin" value="Login">
            </form>
        </div>
    </div>
</body>
</html>