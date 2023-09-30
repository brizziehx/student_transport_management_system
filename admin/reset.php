<?php

    session_start();

    require('../db/db.php');

    $id = $_REQUEST['id'];
    $new_pass = hash('sha1', "Client1234@");

    $reset = $conn->query("UPDATE users SET password = '{$new_pass}' WHERE userID = $id");

    if($reset === true) {
        $_SESSION['msg'] = "<script>vt.success('Password updated Successfully! New password is Client1234@', {duration: 5000, position: 'top-center'})</script>";
        header("Location: users.php");
    }
    
?>