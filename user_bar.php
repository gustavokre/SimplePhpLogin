<div class="user-bar">
    <?php
    const SESSION_DEBUG = false;
    if($userRR->go_online()){
        echo "<p style='color:#3a3;'>ONLINE!</p>";
    }
    else
    {
        echo "<p style='color:#a33;'>OFFLINE!</p>";
    }
    echo "<span>" . MultiLang::get_text("SHOW_USER_NAME") . ": <b>" . $userRR->get_login() . "</b></span><br>";
    echo "<span>" . MultiLang::get_text("SHOW_FULL_NAME") . ": <b>" . $userRR->get_full_name() . "</b></span><br>";
    echo "<span>" . MultiLang::get_text("SHOW_EMAIL") . ": <b>" . $userRR->get_email() . "</b></span><br>";
    if(SESSION_DEBUG){
        echo "SESSION:";
        echo session_id() . "<br>";
        foreach($_SESSION as $key => $val){
            echo "<span>$key : <b>$val</b></span><br>";
        }
    }
    ?>
</div>