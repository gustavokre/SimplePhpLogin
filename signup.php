<?php
    require_once('classes/multilang.php');
    require_once('classes/database.php');
    require_once('classes/validate.php');
    require_once('classes/user.php');
    require_once('classes/register.php');
    
    $dbConnection = new DatabaseConection();
    
    if(!empty($_POST)){
        $userRR = new Register($_POST['login'], $_POST['password'], $_POST['email'], $_POST['fullname']);
        if($userRR->register($dbConnection->getConnection())){
            echo "Register successfully!";
        }
        else
        {
            echo "Database Errors:<br>";
            echo "<pre>" . var_dump($dbConnection->getErrors()) . "</pre><br>";
            echo "Register Class Errors:<br>";
            echo "<pre>" . var_dump($userRR->getErrors()) . "</pre><br>";
            echo "Register failed";
        }
    }
?>