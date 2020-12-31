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
        $userL = new Login($_POST['login'], $_POST['password']);
        if($userL->goOnline($dbConnection->get_connection())){
            echo MultiLang::get_text("LOGIN_DONE") . "<br>";
            echo MultiLang::get_text("SHOW_FULL_NAME") . ": " . $userL->get_full_name() . "<br>";
            echo MultiLang::get_text("SHOW_USER_NAME") . ": " . $userL->get_login() . "<br>";
            echo MultiLang::get_text("SHOW_EMAIL") . ": " . $userL->get_email() . "<br>";
            echo MultiLang::get_text("SHOW_JOIN_DATE") . ": " . $userL->get_join_date() . "<br>";
            echo "<a href=\"../\">" . MultiLang::get_text("BACK") . "</a>";
        }
        else
        {
            if(isset($userL->get_errors()[0]))
                $_SESSION["ERRORS"] = $userL->get_errors()[0];
            else
                $_SESSION["ERRORS"] = MultiLang::get_text("ERROR_UNEXPECTED");

            header("Location:../index.php?error=true");
            exit();
        }
    }
?>