<?php
    require_once('../classes/Session_manager.php');
    require_once('../classes/Multilang.php');
    require_once('../classes/Database_connection.php');
    require_once('../classes/Validate.php');
    require_once('../classes/User.php');
    require_once('../classes/Login_session.php');
    
    $dbConnection = new Database_connection();
    Session_manager::start();
    $userRR = new Login_session();
    $userRR->go_offline();
    header("location: ../");
?>