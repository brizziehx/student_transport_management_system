<?php

    session_start();

    require('../db/db.php');
    
    $locationID = $_REQUEST['locationID'];

    $sql = $conn->query("SELECT * FROM stop WHERE locationID = '$locationID'");
    $row = $sql->fetch_assoc();
    $routeID = $row['routeID'];

    $_SESSION['name'] = $row['locationName'];

    $notification = $_SESSION['name']." location has been deleted successfully";


    $delete = $conn->query("DELETE FROM stop WHERE locationID = '$locationID'");
    


    if($delete === true) {
        $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
        $name =  $_SESSION['name'];
        $_SESSION['msg'] = "<script>vt.success('$name location been deleted successfully', {position: 'top-center'})</script>";
        header("Location: stops.php?routeID=$routeID");
    }
    
?>