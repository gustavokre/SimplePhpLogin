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
            echo "Join Date:" . $userPP->get_join_date() . "<br>";
            echo "<a href=\"../\">Back</a>";
        }
        else
        {
            if(isset($userPP->get_errors()[0]))
                $_SESSION["ERRORS"] = $userPP->get_errors()[0];
            else
                $_SESSION["ERRORS"] = "Erro inesperado";

            header("Location:../index.php?error=true");
            exit();
        }
    }
?>