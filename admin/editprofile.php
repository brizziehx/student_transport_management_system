<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }
    $i = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row2 = $i->fetch_assoc();

    if(isset($_POST['submit'])) {
        $i = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
        $row2 = $i->fetch_assoc();

        $now_Pass = $row2['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $pass = $_POST['password'];
        $pass2 = $_POST['password2'];
        $currpass = hash('sha1', $_POST['password3']);
        $gender = $_POST['gender'] ?? '';

        $firstname = trim($firstname);
        $lastname = trim($lastname);
        $email = trim($email);
        $phone = trim($phone);
        $gender = trim($gender);

        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $email = addslashes($email);
        $phone = addslashes($phone);
        $gender = addslashes($gender);
        $pass = addslashes($pass);

        $_SESSION['pass'] = $pass;
        $_SESSION['pass2'] = $pass2;
        $_SESSION['pass3'] = $currpass;

        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($phone) && !empty($pass) && !empty($pass2) && !empty($gender)) {
            if(preg_match('/^[A-Z][a-zA-Z]{2,}$/', $firstname)) {
                if(preg_match('/^[A-Z][a-zA-Z]{2,}$/', $lastname)) {
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        if(preg_match('/^[0-9]{10}$/', $phone)){
                            if($currpass === $now_Pass) {
                                if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/', $pass)) {
                                    if($pass2 != $pass) {
                                        $_SESSION['msg'] =  "Passwords doesn't match";
                                    } else {
                                        if(!empty($_FILES['image'])) {
                                            $imgName = $_FILES['image']['name'];
                                            $tmpName = $_FILES['image']['tmp_name'];
                                            $location = '../uploads/'.$imgName;
                                            $extensions = ['png','jpg','jpeg'];
                                    
                                            //explode
                                            $img_exp = explode('.', $imgName);
                                            $img_ext = strtolower(end($img_exp));
                                    
                                            if(in_array($img_ext, $extensions)) {
                                    
                                    
                                                $notification = $firstname." ".$lastname."\'s account has been updated successfully!";
                                    
                                                $pass = hash('sha1', $pass);
                                                
                                                $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', password = '$pass', image = '$imgName', gender = '$gender' WHERE userID = {$_SESSION['unique_id']}";
                                                $query = $conn->query($sql);
                                                if($query == true) {

                                                    $_SESSION['admin'] = $firstname;
            
                                                    unset($_SESSION['pass']);
                                                    unset($_SESSION['pass2']);
                                                    unset($_SESSION['pass3']);
                                                    
                                                    
                                    
                                                    unlink("../uploads/".$row2['image']);
                                    
                                                    move_uploaded_file($tmpName, $location);
                                                    $_SESSION['msg'] =  "<script>vt.success('Your account has been updated successfully!', {position: 'top-center'})</script>";
            
                                    
                                                    $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
                                                } else {
                                                    $_SESSION['msg'] =  "An error has occured'";
                                                }
                                            } else { 
                                                $_SESSION['msg'] =  "Invalid image file..";
                                            }
                                        } else {
                                            $_SESSION['msg'] =  "An image is required..";
                                        }
                                    }
                                } else {
                                    $_SESSION['msg'] =  "Password must contain at least eight characters, one number and both lower and uppercase letters  and special characters";
                                }
                            } else {
                                $_SESSION['msg'] = "Wrong current password";
                            }
                                
                        } else {
                            $_SESSION['msg'] =  "A phone number must be a valid number";
                        }
                    } else {
                        $_SESSION['msg'] =  "An email must be a valid email";
                    }
                } else {
                    $_SESSION['msg'] = "Lastname must start with an uppercase also atleast 3 chars long and contain letters only";
                }
            } else {
                $_SESSION['msg'] = "Firstname must start with an uppercase also atleast 3 chars long and contain letters only";
            }
        } else {
            $_SESSION['msg'] =  "All input fields are required";
        }
        
        
    }


    include('greet.php');

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();

    $users = $conn->query("SELECT * FROM users WHERE NOT usertype = '{$row['usertype']}'");

    $dateTime = explode(' ', $row['createdAt']);
    
    $date = explode('-', $dateTime[0]);
    $time = explode(':', $dateTime[1]);
    // print_r($time);return;
    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    $hour = $time[0];
    $min = $time[1];
    $sec = $time[2];

    $timestamp = mktime($hour, $min, $sec, $month, $day, $year);
    // date('jS F Y', $timestamp)

    include('update.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ========= CSS ========== -->
    <link rel="stylesheet" href="../style.css">

    <!-- ========= BOXICONS  CSS ========== -->
    <link rel="stylesheet" href="../boxicons/css/boxicons.min.css">
 
    <style>
        table {
            width: 100%;
            /* border: 1px solid black; */
            border: none;
        }
        table td {
            text-align: left;
            border: none;
            /* border: 1px solid black; */
        }
        table tr:hover {
            box-shadow: none;
        }
        .cards .btn {
            background: #695CFE;
            color: #fff;
        }
        .cards .btn:hover {
            background: #8378f3;
            color: #fff;
        }
    </style>
    <title>Dashboard - Profile Settings</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../assets/mission.png" alt="">
                </span>
                <div class="text header-text">
                    <span class="name">School Transport</span>
                    <div class="profession">Management System</div>
                </div>
            </div>

            <i class="bx bx-chevron-right toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class="bx bx-search icon"></i>
                    <input type="text" name="searchTerm" placeholder="search...">
                </li>
                <ul class="menu-links">
                    <li class="nav-links">
                        <a href="index.php" class="">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-links">
                        <a href="users.php" class="">
                            <i class="bx bx-user icon"></i>
                            <span class="text nav-text">Users</span>
                        </a>
                    </li>

                    <li class="nav-links">
                        <a href="notification.php" class="">
                            <i class="bx bx-bell icon"></i>
                            <span class="text nav-text">Notifications</span>
                        </a>
                    </li>

                    <li class="nav-links">
                    <a href="routes.php" class="">
                            <i class="bx bx-trip icon"></i>
                            <span class="text nav-text">Routes</span>
                        </a>
                    </li>

                    <li class="nav-links">
                        <a href="busses.php" class="">
                            <i class="bx bx-bus-school icon"></i>
                            <span class="text nav-text">Buses</span>
                        </a>
                    </li>

                    <li class="nav-links">
                        <a href="logs.php" class="">
                            <i class="bx bx-task icon"></i>
                            <span class="text nav-text">Logs</span>
                        </a>
                    </li>

                    <li class="nav-links">
                        <a href="settings.php" class="active">
                            <i class="bx bx-cog icon"></i>
                            <span class="text nav-text">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="logout.php?logout_id=<?php echo $row['userID'] ?>">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <!-- <li class="mode">
                    <div class="moon-sun">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li> -->
            </div>
        </div>
    </nav>

    <main class="home grid">
        <header>
            <!-- <h2>School Transportation Management System</h2> -->
            <h2><?=$greetings?><span style="text-transform:capitalize"><?=$_SESSION['admin']?></span>!</h2>
            <div class="user">
                <span class="username"><?php echo $row['firstname'].' '.$row['lastname'] ?><span class="utype"><?=$row['usertype']?></span></span>
                <img src="../uploads/<?=$row['image']?>" >
            </div>
        </header>

        <div class="cards grid">
            <div href="#" class="card xpand2 ypand2" >
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="settings.php">Account Information</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Account Settings</li>
                    </ol>
                </nav>
                <!-- <h3>Profile</h3> -->
                <div class="details">
                    
                    <table>
                        <tr>
                            <td>Full Name:</td><td><b><?=$row['firstname'].' '.$row['lastname']?></b></td><td></td><td rowspan="6" style="width: 38%"><img class="adimg" src="../uploads/<?=$row['image']?>" alt=""></td>
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
                            <td>Member Since:</td><td  colspan="2"><b><?=date('jS F Y', $timestamp) ?>&nbsp; &nbsp; | &nbsp; &nbsp;<?=$hour.' : '.$min.' : '.$sec ?></b></td>
                        </tr>
                        <tr>
                            <td>Last Account Update:</td><td colspan="2"><b><?=date('jS F Y', $timestamp2) ?>&nbsp; &nbsp; | &nbsp; &nbsp;<?=$hour2.' : '.$min2.' : '.$sec2 ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card pand ypand edit">
                <form class="register" method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                    <h3>Account Settings</h3>
                    <div class="inputs">
                        <div class="input">
                            <label for="firstname">Firstname</label>
                            <input type="text" name="firstname" value="<?=$row['firstname']?>" placeholder="Firstname">
                        </div>
                        <div class="input">
                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" value="<?=$row['lastname']?>" placeholder="Lastname">
                        </div>
                    </div>
                    <div class="input">
                        <label for="email">Email Address</label>
                        <input type="text" name="email" value="<?=$row['email']?>" placeholder="you@example.com">
                    </div>
                    <div class="input">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" value="<?=$row['phone']?>" placeholder="eg. 0676100100">
                    </div>
                    <div class="input">
                        <label for="password">Current Password</label>
                        <input type="password" name="password3" value="<?=$_SESSION['pass3'] ?? '' ?>" placeholder=" Current password">
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="password">Password</label>
                            <input type="password" name="password" value="<?=$_SESSION['pass'] ?? '' ?>" placeholder="password">
                        </div>
                        <div class="input">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="password2" value="<?=$_SESSION['pass2'] ?? '' ?>" placeholder="repeat password">
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="image">Image</label>
                            <input type="file" name="image">
                        </div>

                        <div class="input">
                            <label for="image">Gender</label>
                            <select name="gender">
                                <option disabled selected>Select gender...</option>
                                <option <?=$male ?? ''?> value="male">Male</option>
                                <option <?=$female ?? ''?> value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="input">
                        <label for="usertype">User type</label>
                        <input type="text" name="usertype" value="<?=$row['usertype']?>" disabled>
                    </div>
                    
                    
                    <button type="submit" name="submit" >Update Profile</button>
                    <script src="../js/lib/vanilla-toast.min.js"></script>
                    <div class="errorText">
                        <?=$_SESSION['msg'] ?? '' ?>
                        <?php unset($_SESSION['msg']) ?>
                    </div>
                </form>
            </div>
            
        </div>
        
        <footer>
            <p>School Transport Management System &copy; 2023. All Rights Reserved</p>
        </footer>
    </main>
    <script src="../js/script.js"></script>
</body>
</html>
