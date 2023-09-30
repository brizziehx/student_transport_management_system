<?php

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    $delete = $conn->query("TRUNCATE TABLE feedback");

    if($delete == true) {
        $_SESSION['msg'] = "<script>vt.success('All feedbacks have been deleted successfully', {duration: 2500, position: 'top-center'})</script>";
        header("Location: index.php");
    }

?>