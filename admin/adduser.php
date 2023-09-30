<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }
    
    $total_records_per_page = 3;
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2"; 

    $result_count = $conn->query("SELECT COUNT(*) As total_records FROM users");
    $total_records = $result_count->fetch_array();
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total page minus 1

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();




    if(isset($_POST['submit'])) {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $gender = $_POST['gender'] ?? '';
        $usertype = $_POST['utype'] ?? '';
        $status = 'active';

        $firstname = trim($firstname);
        $lastname = trim($lastname);
        $email = trim($email);
        $phone = trim($phone);
        $gender = trim($gender);
        $usertype = trim($usertype);

        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $email = addslashes($email);
        $phone = addslashes($phone);
        $password = addslashes($password);
        $password2 = addslashes($password2);
        $gender = addslashes($gender);
        $usertype = addslashes($usertype);

        $_SESSION['fname'] = $firstname;
        $_SESSION['lname'] = $lastname;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['pass'] = $password;
        $_SESSION['pass2'] = $password2;
        $_SESSION['gender'] = $gender;
        $_SESSION['usertype'] = $usertype;

        switch($_SESSION['gender']) {
            case "male";
                $male = "selected";
                $female = "";
            break;
            case "female";
                $male = "";
                $female = "selected";
            break;
            default;
                $male = "";
                $female = "";
        }

        switch($_SESSION['usertype']) {
            case "Driver";
                $driver = "selected";
            break;
            default;
                $driver = "";
        }

        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($phone) && !empty($password) && !empty($password2) && !empty($gender) && !empty($usertype)) {
            if(preg_match('/^[A-Z][A-Za-z]{3,20}$/', $firstname)) {
                if(preg_match('/^[A-Z][A-Za-z]{3,20}$/', $lastname)) {
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/', $password)) {
                            if($password2 != $password) {
                                $_SESSION['msg'] =  "<script>vt.error('Passwords doesn\'t match', {title: 'Error', position: 'top-center'})</script>";
                            } else {
                                if(preg_match('/^[0-9]{10}$/', $phone)){
                                    if(!empty($_FILES['image'])) {
                                        $imgName = $_FILES['image']['name'];
                                        $tmpName = $_FILES['image']['tmp_name'];
                                        $location = '../uploads/'.$imgName;
                                        $extensions = ['png','jpg','jpeg'];
                
                                        //explode
                                        $img_exp = explode('.', $imgName);
                                        $img_ext = strtolower(end($img_exp));
                
                                        if(in_array($img_ext, $extensions)) {
                
                                            $checkUser = $conn->query("SELECT * FROM users WHERE email = '$email'");
                                            if($checkUser->num_rows > 0) {
                                                $_SESSION['msg'] =  "<script>vt.error('$email - Already exists', {title: 'Error', position: 'top-center'})</script>";
                                            } else {
                                                $password = hash('sha1', $password);
                                                $notification = "$firstname $lastname\'s account has been registered successfully!";
                
                                                $sql = "INSERT INTO users (firstname, lastname, email, phone, password, image, gender, usertype, status) VALUES ('$firstname','$lastname','$email','$phone','$password','$imgName','$gender','$usertype','$status')";
                                                $query = $conn->query($sql);
                                                if($query == true) {
                
                                                    move_uploaded_file($tmpName, $location);
                
                                                    unset($_SESSION['fname']);
                                                    unset($_SESSION['lname']);
                                                    unset($_SESSION['email']);
                                                    unset($_SESSION['phone']);
                                                    unset($_SESSION['pass']);
                                                    unset($_SESSION['pass2']);
                                                    unset($_SESSION['gender']);
                
                                                    $_SESSION['msg'] = '';
                                                    $_SESSION['msg'] =  "<script>vt.success('Account has been created successfully', {position: 'top-center'})</script>";
                                                    $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
                                                } else {
                                                    $_SESSION['msg'] =  "An error has occured";
                                                }
                                            }
                                        } else {
                                            $_SESSION['msg'] =  "Invalid image file";
                                        }
                                    } else {
                                         $_SESSION['msg'] =  "An image is required..";
                                    }
                                } else {
                                    $_SESSION['msg'] =  "A phone number must be a valid number";
                                }
                            }
                        } else {
                            $_SESSION['msg'] =  "Password must contain at least eight characters,<br> one number and both lower and uppercase letters <br> and special characters";
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
     $driverRoute = $conn->query("SELECT * FROM route"); 
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
 
    <title>Dashboard - Add User</title>
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
                        <li class="breadcrumb-item active" aria-current="page"><a href="users.php">All Drivers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New Driver</li>
                    </ol>
                </nav>
                
                <div class="table">

                <table>
                    
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                        $result = $conn->query("SELECT * FROM users ORDER BY userID DESC LIMIT $offset, $total_records_per_page");
                        while($row = $result->fetch_array()){

                            echo "<tr>
                                <td>".$row['userID']."</td>
                                <td>".$row['firstname'].' '.$row['lastname']."</td>
                                <td>".$row['email']."</td>
                                <td>".$row['gender']."</td>
                                </tr>" ?>
                                    
                         <?php  }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
            <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>

            <ul class="pagination">
                <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
                
                <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
                <a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
                </li>
                
                <?php 
                    if ($total_no_of_pages <= 10){  	 
                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                            if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";	
                                }else{
                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                }
                        }
                    }
                    elseif($total_no_of_pages > 10){
                    
                    if($page_no <= 4) {			
                        for ($counter = 1; $counter < 8; $counter++){		 
                                if ($counter == $page_no) {
                                        echo "<li class='active'><a>$counter</a></li>";	
                                    }else{
                                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                    }
                        }
                                echo "<li><a>...</a></li>";
                                echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                                echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    }

                    elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
                        echo "<li><a href='?page_no=1'>1</a></li>";
                        echo "<li><a href='?page_no=2'>2</a></li>";
                        echo "<li><a>...</a></li>";
                        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                        if ($counter == $page_no) {
                                echo "<li class='active'><a>$counter</a></li>";	
                            }else{
                                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                            }                  
                        }
                            echo "<li><a>...</a></li>";
                            echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                            echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
                    }
                        
                    else {
                        echo "<li><a href='?page_no=1'>1</a></li>";
                        echo "<li><a href='?page_no=2'>2</a></li>";
                        echo "<li><a>...</a></li>";

                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                    if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";	
                    }else{
                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                    }                   
                }
                    }
                }
            ?>
                
                <li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
                <a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
                </li>
                <?php if($page_no < $total_no_of_pages){
                    echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                    } ?>
            </ul>
        </div>

        <div class="card pand ypand edit">
                <form class="register" method="POST" action="" enctype="multipart/form-data">
                    <h3>Registation Form</h3>
                    <div class="inputs">
                        <div class="input">
                            <label for="firstname">Firstname</label>
                            <input type="text" name="firstname" value="<?=$_SESSION['fname'] ?? ''?>" placeholder="Firstname">
                        </div>
                        <div class="input">
                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" value="<?=$_SESSION['lname'] ?? ''?>" placeholder="Lastname">
                        </div>
                    </div>
                    <div class="input">
                        <label for="email">Email Address</label>
                        <input type="text" name="email" value="<?=$_SESSION['email'] ?? ''?>" placeholder="you@example.com">
                    </div>
                    <div class="input">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" value="<?=$_SESSION['phone'] ?? ''?>" placeholder="eg. 0676100100">
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="password">Password</label>
                            <input type="password" name="password" value="<?=$_SESSION['pass'] ?? ''?>" placeholder="password">
                        </div>
                        <div class="input">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="password2" value="<?=$_SESSION['pass2'] ?? ''?>" placeholder="repeat password">
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
                        <select name="utype" class="utype">
                            <option disabled selected>Select user type...</option>
                            <!-- <option <?=$administrator ?? ''?> value="School Manager">School Manager</option> -->
                            <option <?=$driver ?? ''?> value="Driver">Driver</option>
                        </select>
                    </div>
                    
                    
                    <button type="submit" name="submit" >Register User</button>
                    <script src="../js/lib/vanilla-toast.min.js"></script>
                    <div class="errorText">
                        <?=$_SESSION['msg'] ?? '' ?>
                        <?php unset($_SESSION['msg']) ?>
                    </div>
                </form>
            </div>

        </div>
        </div>

        </div>
        
        <footer>
            <p>School Transport Management System &copy; 2023. All Rights Reserved</p>
        </footer>
    </main>
    <script src="../js/script.js"></script>
    <script src="../js/form.js"></script>
</body>
</html>