<div class="user-bar">
    <?php
    if($userRR->go_online()){
        echo "<p style='color:#3a3;'>ONLINE!</p>";
    }
    else
    {
        echo "<p style='color:#a33;'>OFFLINE!</p>";
    }
    echo "SESSION:";
    echo session_id() . "<br>";
        foreach($_SESSION as $key => $val){
            echo "<span>$key : <b>$val</b></span><br>";
        }
    ?>
</div>