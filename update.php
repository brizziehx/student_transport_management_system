<?php
    session_start();

    require('db/db.php');
    $user = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $user->fetch_assoc();
    $name = $row['firstname'].' '.$row['lastname'];
    $gen = ($row['gender'] == 'male') ? 'his' : 'her';
    $reseted_pass = 'Client1234@';

    if(!isset($_SESSION['password'])) {
        header("Location: login.php");
    }

    if(isset($_POST['update'])) {
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if(!empty($password) && !empty($password2)) {
            if($password2 != $password) {
                $_SESSION['msg'] = "Passwords doesn't match";
            } elseif($password == $reseted_pass){
                $_SESSION['msg'] = "Please choose another password";
            } else {
                $password = trim($password);
                $password = hash('sha1', $password);
                $notification = $name." updated ".$gen." password successfully!";

                $success = $conn->query("UPDATE users SET password = '{$password}' WHERE userID = {$_SESSION['unique_id']}");
 
                if($success == true) {
                    unset($_SESSION['password']);
                    $conn->query("INSERT INTO nots (notification) VALUES ('$notification')");
                    header("Location: index.php");
                }
            }
        } else {
            $_SESSION['msg'] = "All fields are required";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Update Password | Student Transport Management System</title>
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <h3>Update your Password to Continue</h3>
            <div class="input">
                <label for="password">New Password</label>
                <input type="password" name="password"  placeholder="Enter new password" autocomplete="off">
            </div>
            <div class="input">
                <label for="password">Repeat New Password</label>
                <input type="password" name="password2" placeholder="Repeat password" autocomplete="off">
            </div>
            <button type="submit" name="update" >Update</button>
            <div class="errorText">
                <?=$_SESSION['msg'] ?? '' ?>
                <?php unset($_SESSION['msg']) ?>
            </div>
        </form>
    </div>
</body>
</html>