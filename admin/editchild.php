<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    $childID = $_GET['childID'];

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();


    $student = $conn->query("SELECT * FROM student WHERE studentID = '$childID'");
    $row5 = $student->fetch_assoc();

    if($row5['studentID'] === $childID) {
        $firstname = $row5['firstname'];
        $lastname = $row5['lastname'];
        $pname = $row5['parentName'];
        $phone = $row5['phone'];
        $phone2 = $row5['phone2'];
    } else {
        header("Location: 404.php");
    }


    if(isset($_POST['new']) && $_POST['new']==1) {
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $pname = $_POST['pname'];
        $phone = $_POST['phone'];
        $phone2 = $_POST['phone2'];
        $location = $_POST['location'] ?? '';
        // $payment_status = $_POST['payment_status'] ?? '';
        

        $firstname = trim($firstname);
        $lastname = trim($lastname);
        $pname = trim($pname);
       
        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $pname = addslashes($pname);

        if(!empty($firstname) && !empty($lastname) && !empty($pname) && !empty($phone) && !empty($phone2) && !empty($location)) {
           
            if(preg_match('/^[A-Z][a-zA-Z]{2,}$/', $firstname)) {
                if(preg_match('/^[A-Z][a-zA-Z]{2,}$/', $lastname)) {
                    if(preg_match('/^[A-Z][a-zA-Z ]{2,}$/', $pname)) {
                        if(preg_match('/^[0-9]{10}$/', $phone)){
                            if(preg_match('/^[0-9]{10}$/', $phone2)){
                                $update = $conn->query("UPDATE student SET firstname = '$firstname', lastname = '$lastname', parentName = '$pname', phone = '$phone', phone2 = '$phone2', locationID = '$location' WHERE studentID = $childID");

                                $notification = "$firstname $lastname\'s  details has been updated successfully";

                                if($update === true) {
                                    
                                    $_SESSION['msg'] = "<script>vt.success('$firstname\'s details has been updated successfully', {duration: 2500, position: 'top-center'})</script>";
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

    $update = $conn->query("SELECT * FROM student WHERE studentID = '$childID'");
    $row3 = $update->fetch_array();

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
 
    <title>Dashboard - Edit Child</title>
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
                        <li class="breadcrumb-item active" aria-current="page"><a href="students.php">All Students</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $row3['firstname'].' '.$row3['lastname']?></li>
                    </ol>
                </nav>
                <div class="table">

                    <table style="margin: 10px 0px 0px">
            
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Parent</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?=$row3['studentID']?>
                                </td>
                                <td>
                                    <?=$row3['firstname']?>
                                </td>
                                <td>
                                    <?=$row3['lastname']?>
                                </td>
                                <td>
                                    <?=$row3['parentName']?>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>


            <div class="card pand ypand edit">
                <form class="register" method="POST" action="" enctype="multipart/form-data">
                    <h3>Update <?php echo $row5['firstname']?>'s Details</h3>
                    <div class="inputs">
                        <input type="hidden" name="new" value="1">
                        <input type="hidden" name="id" value="<?=$row2['userID']?>">
                    </div>
                    <div class="input">
                        <label for="firstname">Firstname</label>
                        <input type="text" name="firstname" value="<?=$firstname?>" placeholder="Firstname">
                    </div>
                    <div class="input">
                        <label for="lastname">Lastname</label>
                        <input type="text" name="lastname" value="<?=$lastname?>" placeholder="Lastname">
                    </div>
                    <div class="input">
                        <label>Parent name</label>
                        <input type="text" name="pname" value="<?=$pname?>" placeholder="Parent name">
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label>Phone number</label>
                            <input type="text" name="phone" value="<?=$phone?>" placeholder="eg. 0712110011">
                        </div>
                        <div class="input">
                            <label>Phone number II</label>
                            <input type="text" name="phone2" value="<?=$phone2?>" placeholder="eg. 0712110011">
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
                            <option  value="cleared">Paid</option>
                            <option value="uncleared">Unpaid</option>
                        </select>
                    </div> -->
                    <button type="submit" name="update" >Update Child</button>
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