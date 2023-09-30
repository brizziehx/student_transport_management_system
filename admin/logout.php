<?php

    session_start();
    if(isset($_SESSION['admin'])) {
        require('../db/db.php');
        $logout_id = htmlspecialchars($_GET['logout_id']);
        if(isset($logout_id)) {

            date_default_timezone_set('Africa/Nairobi');
            $logout_time = date("Y-m-d H:i:s");
            
            $sql = $conn->query("UPDATE users SET logouttime = '{$logout_time}' WHERE userID = {$logout_id}");
            if($sql) {
                session_unset();
                session_destroy();
                header("Location: ../login.php");
            }
        } else {
            header("Location: admin/index.php");
        }
    } else {
        header("Location: ../login.php");
    }

?>
