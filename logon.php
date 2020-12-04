<?php
    require_once('classes/database.php');
    require_once('classes/validate.php');
    require_once('classes/user.php');
    require_once('classes/login.php');
    
    $dbConnection = new DatabaseConection();
    
    if(isset($_POST['login']) && isset($_POST['password'])){
        $userPP = new Login($_POST['login'], $_POST['password']);
        if($userPP->goOnline($dbConnection->getConnection())){
            echo "Login successfully!";
        }
        else
        {
            echo "Database Errors:<br>";
            echo "<pre>" . var_dump($dbConnection->getErrors()) . "</pre><br>";
            echo "Login Class Errors:<br>";
            echo "<pre>" . var_dump($userPP->getErrors()) . "</pre><br>";
            echo "Login failed";
        }
    }
?>