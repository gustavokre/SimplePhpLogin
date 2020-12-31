<div class="user-bar">
    <?php
    use gustavokre\classes\MultiLang;
    const SESSION_DEBUG = false;
    if($userL->go_online()){
        echo "<p style='color:#3a3;'>ONLINE!</p>";
        echo "<span>" . MultiLang::get_text("SHOW_USER_NAME") . ": <b>" . $userL->get_login() . "</b></span><br>";
        echo "<span>" . MultiLang::get_text("SHOW_FULL_NAME") . ": <b>" . $userL->get_full_name() . "</b></span><br>";
        echo "<span>" . MultiLang::get_text("SHOW_EMAIL") . ": <b>" . $userL->get_email() . "</b></span><br>";
        echo "<span>" . MultiLang::get_text("SHOW_JOIN_DATE") . ": <b>" . $userL->get_join_date() . "</b></span><br>";
        echo "<a href='account/logout.php'>". MultiLang::get_text("LOGOUT_BUTTON") ."</a>";
    }
    else
    {
        echo "<p style='color:#a33;'>OFFLINE!</p>";
    }
    if(SESSION_DEBUG){
        echo "<br>SESSION:";
        echo session_id() . "<br>";
        foreach($_SESSION as $key => $val){
            echo "<span>$key : <b>$val</b></span><br>";
        }
        echo "CURRENT_TIME: " . time();
    }
    ?>
</div>