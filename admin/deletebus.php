<?php

    session_start();

    require('../db/db.php');
    
    $busID = $_REQUEST['busID'];

    $sql = $conn->query("SELECT * FROM schoolbus WHERE busID = '$busID'");
    $rou = $sql->fetch_assoc();
    $_SESSION['name'] = $rou['busID'];

    $notification = $_SESSION['name']." has been deleted successfully";


    $delete = $conn->query("DELETE FROM schoolbus WHERE busID = '$busID'");
    


    if($delete === true) {
        $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
        $bus = $_SESSION['name'];
        $_SESSION['msg'] = "<script>vt.success('$bus has been deleted successfully', {duration: 2500, position: 'top-center'})</script>";
        header("Location: busses.php");
    }
    
?>