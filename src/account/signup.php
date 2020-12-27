<?php
    require_once('../../vendor/autoload.php');
    use gustavokre\classes\Session_manager;
    use gustavokre\classes\MultiLang;
    use gustavokre\classes\Database_connection;
    use gustavokre\classes\Validate;
    use gustavokre\classes\User;
    use gustavokre\classes\Register;
    
    $dbConnection = new Database_connection();
    
    if(!empty($_POST)){
        $userRR = new Register($_POST['login'], $_POST['password'], $_POST['email'], $_POST['fullname']);
        if($userRR->register($dbConnection->get_connection())){
            echo "Register successfully!<br>";
            echo "Name:" . $userRR->get_full_name() . "<br>";
            echo "Login:" . $userRR->get_login() . "<br>";
            echo "Email:" . $userRR->get_email() . "<br>";
            echo "<a href=\"../\">Back</a>";
        }
        else
        {
            echo "Database Errors:<br>";
            echo "<pre>" . var_dump($dbConnection->get_errors()) . "</pre><br>";
            echo "Register Class Errors:<br>";
            echo "<pre>" . var_dump($userRR->get_errors()) . "</pre><br>";
            echo "Register failed";
            echo "<a href=\"../\">Back</a>";
        }
    }
?>