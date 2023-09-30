<?php

    session_start();

    require('../db/db.php');
    
    $status_active = 'active';

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    $id = htmlentities($_REQUEST['id']);

    $user = $conn->query("SELECT * FROM users WHERE userID = $id");
    $row = $user->fetch_assoc();

    $approve = $conn->query("UPDATE users SET status = '$status_active' WHERE userID = $id");

    if($approve === true) {
        $name = $row['firstname'].' '.$row['lastname'];
        $notification = "$name\'s account is now active";

        $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
        // $_SESSION['msg2'] = "";
        $_SESSION['msg'] = "<script>vt.success('$name\'s account is now active', {position: 'top-center'})</script>";
        header("Location: edit.php?id=$id");

    }

?>

