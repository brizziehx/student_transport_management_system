<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    $id = $_REQUEST['id'];

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();

    $result = $conn->query("SELECT * FROM users WHERE userID = '$id'");
    $row2 = $result->fetch_array();


    if($row2['userID'] === $id) {
        $firstname = $row2['firstname'];
        $lastname = $row2['lastname'];
        $email = $row2['email'];
        $phone = $row2['phone'];
        $pass = hash('sha1', $row2['password']);
        if($row2['gender'] == 'male') {
            $male = $row2['gender'];
        } else {
            $female = $row2['gender'];
        }
    } else {
        header("Location: 404.php");
    }


    if(isset($_POST['new']) && $_POST['new']==1) {
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
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

        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($phone) && !empty($gender)) {
            if(preg_match('/^[A-Z][A-Za-z]{2,20}$/', $firstname)) {
                if(preg_match('/^[A-Z][A-Za-z]{2,20}$/', $lastname)) {
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        if(preg_match('/^[0-9]{10}$/', $phone)){
                            if(!empty($_FILES['image'])) {
                                $imgName = $_FILES['image']['name'];
                                $tmpName = $_FILES['image']['tmp_name'];
                                $extensions = ['png','jpg','jpeg'];
                        
                                //explode
                                $img_exp = explode('.', $imgName);
                                $img_ext = strtolower(end($img_exp));
                        
                                if(in_array($img_ext, $extensions) === true) {
                        
                        
                                    $notification = $firstname." ".$lastname."\'s account has been updated successfully!";
                                    
                                    $time = time();
                
                                    $newImgName = $time.$imgName;
                
                                    $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', image = '$newImgName', gender = '$gender' WHERE userID = $id";
                                    $query = $conn->query($sql);
                                    if($query == true) {
                        
                                        unlink("../uploads/".$row2['image']);
                        
                                        move_uploaded_file($tmpName, '../uploads/'.$newImgName);
                                        $_SESSION['msg'] =  "<script>vt.success('$firstname\'s account has been updated successfully!', {position: 'top-center'})</script>";
                        
                                        $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
                                    } else {
                                        $_SESSION['msg'] =  "An error has occured";
                                    }
                                } else { 
                                    $_SESSION['msg'] =  "Invalid image file..";
                                }
                            } else {
                                $_SESSION['msg'] =  "An image is required..";
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

    





    $update = $conn->query("SELECT * FROM users WHERE userID = '$id'");
    $row4 = $update->fetch_array();
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
 
    <title>Dashboard - Edit User</title>
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
                        <a href="users.php" class="active">
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
                        <a href="settings.php" class="">
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
            
            <div href="#" class="card xpand2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="users.php">All Drivers</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $row4['firstname'].' '.$row4['lastname']?></li>
                    </ol>
                </nav>

                <div class="table">

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Gender</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            echo "<tr>
                                    <td>".$row4['userID']."</td>
                                    <td>".$row4['firstname'].' '.$row4['lastname']."</td>
                                    <td>".$row4['email']."</td>
                                    <td>".$row4['phone']."</td>
                                    <td>".$row4['gender']."</td>
                                </tr>
                        "?>

                        </tbody>

                    </table>
                </div>
            </div>


            <div class="card pand ypand edit">
                <form class="register" method="POST" action="" enctype="multipart/form-data">
                    <h3>Update <?php echo $row4['firstname']?>'s Details</h3>
                    <div class="inputs">
                        <input type="hidden" name="new" value="1">
                        <input type="hidden" name="id" value="<?=$row2['userID']?>">
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="firstname">Firstname</label>
                            <input type="text" name="firstname" value="<?=$firstname?>" placeholder="Firstname">
                        </div>
                        <div class="input">
                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" value="<?=$lastname?>" placeholder="Lastname">
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="email">Email Address</label>
                            <input type="text" name="email" value="<?=$email?>" placeholder="you@example.com">
                        </div>
                        <div class="input">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="phone" value="<?=$phone?>" placeholder="eg. 0622001001">
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="password">Password</label>
                            <input type="password"  disabled placeholder="password">
                        </div>
                        <div class="input">
                            <label for="password">Confirm Password</label>
                            <input type="password"  disabled placeholder="repeat password">
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input" style="width:50%">
                            <label for="image">Image</label>
                            <input type="file" name="image">
                        </div>

                        <div class="input" style="width:45%">
                            <label for="image">Gender</label>
                            <select name="gender">
                                <option disabled selected>Select gender...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="update" >Update User</button>
                    <script src="../js/lib/vanilla-toast.min.js"></script>
                    <div class="errorText">
                        <?=$_SESSION['msg'] ?? '' ?>
                        <?php unset($_SESSION['msg']) ?>
                    </div>
                </form>
            </div>
            
            <img src="../uploads/<?=$row4['image']?>" class="card edit-img">

            </div>

        </div>

        
        <footer>
            <p>School Transport Management System &copy; 2023. All Rights Reserved</p>
        </footer>
    </main>
    <script src="../js/script.js"></script>
</body>
</html>