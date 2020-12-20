<?php
    require_once('classes/Session_manager.php');
    require_once('classes/Multilang.php');
    require_once('classes/Database_connection.php');
    require_once('classes/Validate.php');
    require_once('classes/User.php');
    require_once('classes/Login.php');
    
    $dbConnection = new Database_connection();
    Session_manager::start();
    
    if(isset($_POST['login']) && isset($_POST['password'])){
        $userPP = new Login($_POST['login'], $_POST['password']);
        if($userPP->goOnline($dbConnection->get_connection())){
            echo "Login successfully!<br>";
            echo "Name:" . $userPP->get_full_name() . "<br>";
            echo "Login:" . $userPP->get_login() . "<br>";
            echo "Email:" . $userPP->get_email() . "<br>";
            echo "<a href=\"/\">Back</a>";
        }
        else
        {
            echo "Database Errors:<br>";
            echo "<pre>" . var_dump($dbConnection->get_errors()) . "</pre><br>";
            echo "Login Class Errors:<br>";
            echo "<pre>" . var_dump($userPP->get_errors()) . "</pre><br>";
            echo "Login failed<br>";
            echo "<a href=\"/\">Back</a>";
        }
    }
?>