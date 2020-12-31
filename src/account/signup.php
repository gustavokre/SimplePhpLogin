<?php
    require_once('../../vendor/autoload.php');
    use gustavokre\classes\Session_manager;
    use gustavokre\classes\MultiLang;
    use gustavokre\classes\Database_connection;
    use gustavokre\classes\Validate;
    use gustavokre\classes\User;
    use gustavokre\classes\Register;
    
    $dbConnection = new Database_connection();
    Session_manager::start();
    
    if(!empty($_POST)){
        $userR = new Register($_POST['login'], $_POST['password'], $_POST['email'], $_POST['fullname']);
        if($userR->register($dbConnection->get_connection())){
            echo MultiLang::get_text("REGISTER_DONE") . "<br>";
            echo MultiLang::get_text("SHOW_FULL_NAME") . ": " . $userR->get_full_name() . "<br>";
            echo MultiLang::get_text("SHOW_USER_NAME") . ": " . $userR->get_login() . "<br>";
            echo MultiLang::get_text("SHOW_EMAIL") . ": " . $userR->get_email() . "<br>";
            echo MultiLang::get_text("SHOW_JOIN_DATE") . ": " . $userR->get_join_date() . "<br>";
            echo "<a href=\"../\">" . MultiLang::get_text("BACK") . "</a>";
        }
        else
        {
            if(isset($userR->get_errors()[0]))
                $_SESSION["ERRORS"] = $userR->get_errors()[0];
            else
                $_SESSION["ERRORS"] = MultiLang::get_text("ERROR_UNEXPECTED");

            header("Location:../index.php?error=true");
            exit();
        }
    }
?>