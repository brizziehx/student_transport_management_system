<?php

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    $id = $_REQUEST['id'];

    $delete = $conn->query("DELETE FROM nots WHERE id = {$id}");

    if($delete == true) {
        $_SESSION['msg'] = "<script>vt.success('A notification has been deleted successfully', {duration: 2500, position: 'top-center'})</script>";
        header("Location: notification.php");
    }

?>