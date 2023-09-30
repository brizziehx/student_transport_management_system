<?php
    session_start();
    if(isset($_SESSION['password'])) {
        header("Location: update.php");
    }

    if(!isset($_SESSION['driver'])) {
        header("Location: login.php");
    }


?>