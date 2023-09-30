<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    $routeIDs = $_GET['routeID'];
    $locationID = $_GET['locationID'];

    include('greet.php');

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();


    $route = $conn->query("SELECT * FROM route WHERE routeID = '$routeIDs'");
    $rou = $route->fetch_assoc();

    if(isset($_POST['submit'])) {

        $lname = $_POST['locationName'];
        $time = $_POST['time'];
        $time2 = $_POST['time2'];

        $lname = trim($lname);
        $lname = htmlspecialchars($lname);

        $_SESSION['lname'] = $lname;

        $notification = $_SESSION['lname']." location has been updated successfully";

        if(!empty($lname) && !empty($time) && !empty($time2)) {
            $sql = $conn->query("UPDATE stop SET locationName = '$lname', time = '$time', time2 = '$time2', routeID = '$routeIDs' WHERE locationID = $locationID");

            if($sql == true) {
                $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");

                unset($_SESSION['lname']);
                $_SESSION['msg'] = "<script>vt.success('Location has been updated successfully', {duration: 2500, position: 'top-center'})</script>";
            }
        } else {
            $_SESSION['msg'] = "<script>vt.error('All input fields are required', { title: 'Error', duration: 2500, position: 'top-center'})</script>";
        }

    }

    $locations = $conn->query("SELECT * FROM stop WHERE locationID = $locationID AND routeID = '$routeIDs'");
    $loc = $locations->fetch_assoc();

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
 
    <title>Dashboard - Routes</title>
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
                        <a href="routes.php" class="active">
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
        <?php

            if(isset($_POST['searchTerm'])) {
                echo "<script>alert()</script>";
            }


        ?>

        <div class="cards grid">

            <div href="#" class="card xpand2">
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="routes.php">Routes</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="stops.php?routeID=<?=$_GET['routeID']?>"><?=$rou['name']?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=$loc['locationName']?></li>
                    </ol>
                </nav>
                
                <div class="table">

                <table>
                    <?php if(isset($_SESSION['msg2'])): ?>
                        <caption>
                            <?=$_SESSION['msg2'] ?? '' ?>
                            <?php unset($_SESSION['msg2']) ?>
                        </caption>
                    <?php endif ?>
                    <thead>
                        <tr>
                        <th>Location Name</th>
                        <th>Pick up Time</th>
                        <th>Drop off Time</th>
                        <th>Route ID</th>
                    </tr>
                    </thead>
                    <tbody>
        
                        <tr>
                            <td><?=$loc['locationName']?></td>
                            <td><?=$loc['time']?></td>
                            <td><?=$loc['time2']?></td>
                            <td><?=$loc['routeID']?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        
        </div>
        <div class="card pand ypand edit">
        <form class="register" method="POST" action="" enctype="multipart/form-data">
                    <h3>Update Location</h3>
                    
                    <div class="input">
                        <label for="lname">Location Name</label>
                        <input type="text" name="locationName" value="<?=$loc['locationName']?>" placeholder="Location name">
                    </div>
                    <div class="input">
                        <label for="time">Pick up Time</label>
                        <input type="time" name="time" value="<?=$loc['time']?>">
                    </div>
                    <div class="input">
                        <label for="time">Drop off Time</label>
                        <input type="time" name="time2" value="<?=$loc['time2']?>">
                    </div>

                    <button type="submit" name="submit" >Update Location</button>
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
</body>
</html>