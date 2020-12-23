<?php
    require_once('../classes/Session_manager.php');
    require_once('../classes/Multilang.php');
    require_once('../classes/Database_connection.php');
    require_once('../classes/Validate.php');
    require_once('../classes/User.php');
    require_once('../classes/Register.php');
    
    $dbConnection = new Database_connection();
    
    if(!empty($_POST)){
        $userRR = new Register($_POST['login'], $_POST['password'], $_POST['email'], $_POST['fullname']);
        if($userRR->register($dbConnection->get_connection())){
            echo "Register successfully!<br>";
            echo "Name:" . $userRR->get_full_name() . "<br>";
            echo "Login:" . $userRR->get_login() . "<br>";
            echo "Email:" . $userRR->get_email() . "<br>";
            echo "<a href=\"/\">Back</a>";
        }
        else
        {
            echo "Database Errors:<br>";
            echo "<pre>" . var_dump($dbConnection->get_errors()) . "</pre><br>";
            echo "Register Class Errors:<br>";
            echo "<pre>" . var_dump($userRR->get_errors()) . "</pre><br>";
            echo "Register failed";
            echo "<a href=\"/\">Back</a>";
        }
    }
?>