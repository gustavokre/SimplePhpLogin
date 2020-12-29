<?php
    require_once('../../vendor/autoload.php');
    use gustavokre\classes\Session_manager;
    use gustavokre\classes\MultiLang;
    use gustavokre\classes\Database_connection;
    use gustavokre\classes\Validate;
    use gustavokre\classes\User;
    use gustavokre\classes\Login;
    
    $dbConnection = new Database_connection();
    Session_manager::start();
    
    if(isset($_POST['login']) && isset($_POST['password'])){
        $userPP = new Login($_POST['login'], $_POST['password']);
        if($userPP->goOnline($dbConnection->get_connection())){
            echo "Login successfully!<br>";
            echo "Name:" . $userPP->get_full_name() . "<br>";
            echo "Login:" . $userPP->get_login() . "<br>";
            echo "Email:" . $userPP->get_email() . "<br>";
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