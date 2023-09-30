<?php

    session_start();

    require('../db/db.php');
    
    $routeID = $_REQUEST['routeID'];

    $sql = $conn->query("SELECT * FROM route WHERE routeID = '$routeID'");
    $rou = $sql->fetch_assoc();
    $_SESSION['name'] = $rou['name'];

    $notification = $_SESSION['name']."\'s route has been deleted successfully";


    $delete = $conn->query("DELETE FROM route WHERE routeID = '$routeID'");
    


    if($delete === true) {
        $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
        $name = $_SESSION['name'];
        $_SESSION['msg'] = "<script>vt.success('$name\'s route been deleted successfully', {duration: 2500, position: 'top-center'})</script>";
        header("Location: routes.php");
    }
    
?>