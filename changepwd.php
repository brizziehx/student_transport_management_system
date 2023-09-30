<?php
     require('db/db.php');
     require('auth.php');
     include('admin/greet.php');



    $user = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $user->fetch_assoc();
    $name = $row['firstname'].' '.$row['lastname'];
    $gen = ($row['gender'] == 'male') ? 'his' : 'her';

    if(isset($_POST['update'])) {
        $pass = $_POST['password'];
        $password = $row['password'];
        $current_password = hash('sha1', $_POST['password']);
        $new_password = $_POST['password2'];
        $new2_password = $_POST['password3'];

        $current_password = htmlspecialchars($current_password);
        $new_password = htmlspecialchars($new_password);
        $new2_password = htmlspecialchars($new2_password);

        $_SESSION['pass1'] = $pass;
        $_SESSION['pass2'] = $new_password;
        $_SESSION['pass3'] = $new2_password;


        if(!empty($current_password) && !empty($new_password) && !empty($new2_password)) {
            if($current_password === $password) {
                if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/', $new_password)) {
                    if($new2_password != $new_password) {
                        $_SESSION['msg'] =  "<script>vt.error('Passwords doesn\'t match', {title: 'Error', position: 'top-center'})</script>";
                    } else {
                        $new_password = hash('sha1', $_POST['password2']);
                        $update = $conn->query("UPDATE users SET password = '$new_password' WHERE userID = {$row['userID']}");

                        if($update == true) {
                            unset($_SESSION['pass']);
                            unset($_SESSION['pass2']);
                            unset($_SESSION['pass3']);

                            $notification = "$name has changed $gen password successfully!";
                            $conn->query("INSERT INTO nots (notification) VALUES ('$notification')");
                            $_SESSION['msg'] = "<script>vt.success('Your password has been updated successfully', {position: 'top-center'})</script>";
                        }
                    }
                } else {
                    $_SESSION['msg'] =  "Password must contain at least eight characters,<br> one number and both lower and uppercase letters <br> and special characters";
                }
            } else {
                $_SESSION['msg'] = "Wrong current Password";
            }
        } else {
            $_SESSION['msg'] = "All input fields are required";
        }

    }

    $dateTime = explode(' ', $row['createdAt']);
    
    $date = explode('-', $dateTime[0]);
    $time = explode(':', $dateTime[1]);

    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    $hour = $time[0];
    $min = $time[1];
    $sec = $time[2];

    $timestamp = mktime($hour, $min, $sec, $month, $day, $year);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ustyle.css">
    <!-- ========= BOXICONS  CSS ========== -->
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <title>Change Password | School Transport Management System</title>
    <style>
        table {
            width: 65.5%;
            border: none;
        }
        table td {
            text-align: left;
            border: none;
        }
        table tr:hover {
            box-shadow: none;
        }

        .adimg {
            width: 100%;
            height: 270px;
            object-fit: cover;
        }
        main form .btn {
            background: crimson;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease-in-out;
        }
        main form .btn:hover {
            background:#7e0820;
        }
       
    </style>
</head>
<body>
<script src="js/lib/vanilla-toast.min.js"></script>

    <header class="grid user">
        <h2>School Transport Management System</h2>

        <nav class="user-nav">
            <div class="user">
                <img src="uploads/<?=$row['image']?>" >
                <span class="username"><?php echo $row['firstname'].' '.$row['lastname'] ?><span class="utype"><?=$row['usertype']?></span></span>
            </div>

            <a class="" href="index.php"><i class="bx bx-home"></i>Home</a>
            <a class="active" href="profile.php"><i class="bx bx-user"></i>Profile</a>
            <a class="logout" href="logout.php?logout_id=<?php echo $row['userID'] ?>"><i class="bx bx-log-out"></i>Logout </a>
        </nav>
    </header>
    <main class="grid cards">
        
        <div class="card xpand2 ypand2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="profile.php">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                    </ol>
                </nav>
                <!-- <h3>Profile</h3> -->
                <div class="details">
                    
                    <table>
                        <tr>
                            <td>Full Name:</td><td><b><?=$row['firstname']. ' '.$row['lastname']?></b></td>
                        </tr>
                        <tr>
                            <td>Role:</td><td><b><?=$row['usertype'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Phone Number:</td><td><b><?=$row['phone'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Email Address:</td><td><b><?=$row['email'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Gender:</td><td> <b><?=$row['gender'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Member Since:</td><td><b><?=date('jS F Y', $timestamp) ?>&nbsp; &nbsp; | &nbsp; &nbsp;<?=$hour.' : '.$min.' : '.$sec ?></b></td>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <div class="card edit ypand2 pand">
                <form method="POST" action="">
                    <h3>Change Password</h3>
                    <div class="input">
                        <label for="password">Current Password</label>
                        <input type="password" name="password" value="<?=$_SESSION['pass1'] ?? ''?>"  placeholder="Enter current password" autocomplete="off">
                    </div>
                    <div class="input">
                        <label for="password">New Password</label>
                        <input type="password" name="password2" value="<?=$_SESSION['pass2'] ?? ''?>"  placeholder="Enter new password" autocomplete="off">
                    </div>
                    <div class="input">
                        <label for="password">Repeat New Password</label>
                        <input type="password" name="password3" value="<?=$_SESSION['pass3'] ?? ''?>" placeholder="Repeat new password" autocomplete="off">
                    </div>
                    <button class="btn" type="submit" name="update" >Update Password</button>
                    <div class="errorText">
                        <?=$_SESSION['msg'] ?? '' ?>
                        <?php unset($_SESSION['msg']) ?>
                    </div>
                </form>
            </div>
            <!-- <div class="card">
                <img class="adimg" src="uploads/<?=$row['image']?>" alt="">
            </div> -->
            <!-- <a  href="changepwd.php" class="card btn">
                <h3 align="center">Change Password</h3>
            </a> -->
        </div>

    </main>
</body>
</html>