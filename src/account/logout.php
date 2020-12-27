<?php
    require_once('../../vendor/autoload.php');
    use gustavokre\classes\Session_manager;
    use gustavokre\classes\MultiLang;
    use gustavokre\classes\Database_connection;
    use gustavokre\classes\Validate;
    use gustavokre\classes\User;
    use gustavokre\classes\Login_session;
    
    $dbConnection = new Database_connection();
    Session_manager::start();
    $userRR = new Login_session();
    $userRR->go_offline();
    header("location: ../");
?>