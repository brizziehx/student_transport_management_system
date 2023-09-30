<?php

    session_start();

    require('../db/db.php');
    
    $id = $_REQUEST['id'];

    $child = $conn->query("SELECT * FROM student WHERE studentID = $id");
    $row = $child->fetch_assoc();

    $name = $row['firstname'];
    $notification = $name." has been deleted successfully";


    $delete = $conn->query("DELETE FROM student WHERE studentID = $id");
    


    if($delete === true) {
        $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
        $_SESSION['msg'] = "<script>vt.success('$name has been deleted successfully', {duration: 2500, position: 'top-center'})</script>";
        header("Location: students.php");
    }
    
?>