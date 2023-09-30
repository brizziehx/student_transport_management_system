<?php



    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();

    $errors = array('fname'=>'', 'lname'=>'', 'loc'=>'', 'phone'=>'', 'phone2'=>'');

    if(isset($_POST['submit'])) {
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $location = $_POST['location'] ?? '';
        $pname = $_POST['pname'];
        $phone = $_POST['phone'];
        $phone2 = $_POST['phone2'];
        // $payment_status = $_POST['payment_status'] ?? '';

        $firstname = trim($firstname);
        $lastname = trim($lastname);
        $pname = trim($pname);
        $phone = trim($phone);
        $phone2 = trim($phone2);
        // $payment_status = trim($payment_status);
       
        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $phone = addslashes($phone);
        $phone2 = addslashes($phone2);
        // $payment_status = addslashes($payment_status);

        $_SESSION['fname'] = $firstname;
        $_SESSION['lname'] = $lastname;
        $_SESSION['pname'] = $pname;
        $_SESSION['phone'] = $phone;
        $_SESSION['phone2'] = $phone2;
        // $_SESSION['payment_status'] = $payment_status;

        // switch($_SESSION['payment_status']) {
        //     case "cleared";
        //         $cleared = "selected";
        //         $unclear = "";
        //     break;
        //     case "uncleared";
        //         $cleared = "";
        //         $unclear = "selected";
        //     break;
        //     default;
        //         $cleared = "";
        //         $unclear = "";
        // }
        

        if(!empty($firstname) && !empty($lastname) && !empty($pname) && !empty($phone) && !empty($phone2) && !empty($location)) {
           
            if(preg_match('/^[A-Z][a-zA-Z]{2,}$/', $firstname)) {
                if(preg_match('/^[A-Z][a-zA-Z]{2,}$/', $lastname)) {
                    if(preg_match('/^[A-Z][a-zA-Z ]{2,}$/', $pname)) {
                        if(preg_match('/^[0-9]{10}$/', $phone)){
                            if(preg_match('/^[0-9]{10}$/', $phone2)){
                                $query = $conn->query("INSERT INTO student (firstname, lastname, parentName, phone, phone2, locationID) VALUES ('$firstname', '$lastname', '$pname', '$phone', '$phone2', '$location')");

                                $notification = $_SESSION['fname']." has been added successfully"; 

                                if($query === true) {
                                    unset($_SESSION['fname']);
                                    unset($_SESSION['lname']);
                                    unset($_SESSION['pname']);
                                    unset($_SESSION['phone']);
                                    unset($_SESSION['phone2']);
                                    $_SESSION['msg'] = "<script>vt.success('student has been added successfully', {position: 'top-center'})</script>";
                                    
                                    $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");

                                }
                            } else {
                                $_SESSION['msg'] =  "A phone number II must be a valid number";
                            }
                        } else {
                            $_SESSION['msg'] =  "A phone number must be a valid number";
                        }
                    } else {
                        $_SESSION['msg'] = "Parent name must start with an uppercase also atleast 3 chars long and contain letters only";
                    }
                } else {
                    $_SESSION['msg'] = "Lastname must start with an uppercase also atleast 3 chars long and contain letters only";
                }
            } else {
                $_SESSION['msg'] = "Firstname must start with an uppercase also atleast 3 chars long and contain letters only";
            }
        } else {
            $_SESSION['msg'] = "All input fields are required";
        }
    }

    $student = $conn->query("SELECT * FROM student ORDER BY studentID DESC LIMIT 1");
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
 
    <title>Dashboard - Add Child</title>
</head>
<body>
<script src="../js/lib/vanilla-toast.min.js"></script>
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
                        <li class="breadcrumb-item" aria-current="page"><a href="students.php">All Students</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Student</li>
                    </ol>
                </nav>

                
                <div class="table">
                        <?=$_SESSION['msg2'] ?? '' ?>
                        <?php unset($_SESSION['msg2']) ?>

                    <table>
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Parent Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php   while($row2 = $student->fetch_assoc()){
                            echo "<tr>
                                    <td>".$row2['studentID']."</td>
                                    <td>".$row2['firstname']."</td>
                                    <td>".$row2['lastname']."</td>
                                    <td>".$row2['parentName']."</td>
                                </tr>";
                        }   
                        ?>

                        </tbody>

                    </table>
                </div>
            </div>


            <div class="card pand ypand edit">
                <form class="register" method="POST" action="" enctype="multipart/form-data">
                    <h3>Registration Form</h3>
                    <div class="inputs">
                        <div class="input">
                            <label for="firstname">Firstname</label>
                            <input type="text" name="firstname" value="<?php echo $_SESSION['fname'] ?? ''?>" placeholder="Firstname">
                        </div>
                        <div class="input">
                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" value="<?php echo $_SESSION['lname'] ?? ''?>" placeholder="Lastname">
                        </div>
                    </div>
                    <div class="input">
                        <label>Parent name</label>
                        <input type="text" name="pname" value="<?php echo $_SESSION['pname'] ?? ''?>" placeholder="Parent name">
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label>Phone number</label>
                            <input type="text" name="phone" value="<?php echo $_SESSION['phone'] ?? ''?>" placeholder="eg. 0712110011">
                        </div>
                        <div class="input">
                            <label>Phone number II</label>
                            <input type="text" name="phone2" value="<?php echo $_SESSION['phone2'] ?? ''?>" placeholder="eg. 0712110011">
                        </div>
                    </div>
                    <div class="input">

                        <label for="location">Route based on location</label>
                        <select name="location">
                            <option disabled selected>Select route...</option>
                            <?php
                                $routes = $conn->query("SELECT * FROM route");
                                if($routes->num_rows > 0): 
                                    while($row = $routes->fetch_assoc()): ?>
                                        <optgroup label="<?=$row['name']?>">
                                            <?php $locations = $conn->query("SELECT * FROM stop WHERE routeID = '{$row['routeID']}'");
                                                if($locations->num_rows > 0):
                                                    while($row = $locations->fetch_assoc()): ?>
                                                            <option value="<?=$row['locationID']?>"><?=$row['locationName']?></option>
                                            <?php endwhile; endif; endwhile; ?>
                                        </optgroup>
                                        <?php endif; ?>
                        </select>
                    </div>
                    <!-- <div class="input">
                        <label for="payment">Payment Status</label>
                        <select name="payment_status">
                            <option selected disabled>Select payment status for this child...</option>
                            <option <?=$cleared ?? ''?> value="cleared">Paid</option>
                            <option <?=$unclear ?? ''?> value="uncleared">Unpaid</option>
                        </select>
                    </div> -->
                    <button type="submit" name="submit" >Register</button>
                    
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