<?php

    session_start();

    require('../db/db.php');
    
    $id = $_REQUEST['id'];


    $user = $conn->query("SELECT image FROM users WHERE userID = '$id'");
    $row = $user->fetch_assoc();



    $delete = $conn->query("DELETE FROM users WHERE userID = '$id'");

    if($delete === true) {

        unlink("../uploads/".$row['image']);
        $_SESSION['msg'] = "<script>vt.success('A user has been deleted successfully', {duration: 2500, position: 'top-center'})</script>";
        header("Location: users.php");
    }
    
?>