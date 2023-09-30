<?php

    session_start();
    require('db/db.php');

    if(isset($_SESSION['admin'])) {
        header("Location: admin/index.php");
    }

    if(isset($_SESSION['driver'])) {
        header("Location: index.php");
    }

    if(isset($_POST['submit'])) {

        $email = $_POST['email'];
        $password = hash('sha1', $_POST['password']);
        
        if($password == hash('sha1', 'Client1234@')) {
            $_SESSION['password'] = $password;
        }

        $email = trim($email);
        $password = trim($password);

        $email = addslashes($email);
        $password = addslashes($password);

        $_SESSION['email'] = $email;

        if(!empty($email) && !empty($password)) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['msg'] = "Please enter a valid email";
            } else {
                $sql = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'";
                $res = $conn->query($sql);

                if($res->num_rows > 0) {
                    $row = $res->fetch_assoc();

                    date_default_timezone_set('Africa/Nairobi');
                    $time = date('Y-m-d H:i:s');
                        
                    $conn->query("UPDATE users SET logintime = '{$time}' WHERE userID = {$row['userID']}");
                    unset($_SESSION['email']);

                    if($row['usertype'] == 'School Manager') {
                        $_SESSION['unique_id'] = $row['userID'];
                        $_SESSION['admin'] = $row['firstname'];
                        header("Location: admin/index.php");

                    } elseif($row['usertype'] == 'Driver') {
                        $_SESSION['unique_id'] = $row['userID'];
                        $_SESSION['driver'] = $row['firstname'];
                        header("Location: index.php");
                    }
                } else {

                    $_SESSION['msg'] = "Email or password is incorrect";

                }
            }
            
        } else {
            $_SESSION['msg'] = "All input fields are required";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ====== CSS ====== -->
    <link rel="stylesheet" href="style.css">

    <!-- ========= Js =========== -->
    <title>Login | School Transport Management System</title>
</head>
<body>
<script src="js/lib/vanilla-toast.min.js"></script>
    <div class="container">
        <form method="POST" action="">
            <h3>School Transport Management System</h3>
            <div class="input">
                <label for="email">Email Address</label>
                <input type="text" name="email" value="<?=$_SESSION['email'] ?? ''?>" placeholder="you@example.com" autocomplete="off">
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="password" autocomplete="off">
            </div>
            <button type="submit" name="submit" >Login</button>
            <div class="errorText">
                <?=$_SESSION['msg'] ?? '' ?>
                <?php unset($_SESSION['msg']) ?>
            </div>
            
        </form>
            
    </div>
    <!-- <script src="js/login.js"></script> -->
    <script src="js/script.js"></script>
</body>
</html>