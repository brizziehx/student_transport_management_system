<?php 
    error_reporting(0);
    session_start();
    require('../db/db.php');

    $userID = $_GET['id'];

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');


    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();

    $driverRoute = $conn->query("SELECT * FROM route"); 


    if(isset($_POST['submit'])) {
        $route = $_POST['route'] ?? '';

        if(!empty($route)) {
            $routes = $conn->query("SELECT * FROM schoolbus WHERE routeID = '{$route}'"); 
            
            if($routes->num_rows > 0) {
                $_SESSION['msg'] = "<script>vt.error('This route has already been asigned', { title: 'Error', position: 'top-center'})</script>";
            } else {
                //  $notification;
                $update = $conn->query("UPDATE schoolbus SET routeID = '$route' WHERE driverID = '$userID'");
                if($update == true) {
                    $_SESSION['msg'] = "<script>vt.success('Driver has been assigned successfully', {position: 'top-center'})</script>";
                }
            }
        } else {
            $_SESSION['msg'] = "<script>vt.error('Please select route', { title: 'Error', position: 'top-center'})</script>";
        }
    }

    $drv = $conn->query("SELECT * FROM users WHERE userID = $userID AND usertype = 'Driver'");

    $drvrDetail = $drv->fetch_assoc();
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
 
    <title>Dashboard - All Users</title>
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
        <?php

            if(isset($_POST['searchTerm'])) {
                echo "<script>alert()</script>";
            }


        ?>

        <div class="cards grid">

            <div href="#" class="card xxpand">
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="drivers.php">All Drivers</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=$drvrDetail['firstname'].' '.$drvrDetail['lastname']?></li>
                    </ol>
                </nav>
                
                <div class="table">

                    <table>
                        
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Bus ID</th>
                            <th>Route</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $result = $conn->query("SELECT * FROM users WHERE usertype = 'Driver' AND userID = $userID");
                            while($row = $result->fetch_array()){
                                $bus =$conn->query("SELECT * FROM schoolbus WHERE driverID = {$row['userID']}");
                                $busDriver = $bus->fetch_assoc();

                                $route = $conn->query("SELECT * FROM route WHERE routeID = '{$busDriver['routeID']}'");
                                $routetaken = $route->fetch_assoc();

    

                                if($routetaken['name'] == NULL) {
                                    $routeTkn = "Not yet assigned";
                                } else {
                                    $routeTkn = $routetaken['name'];
                                }

                                if($busDriver['busID'] == NULL) {
                                    $busID = "Not yet assigned";
                                } else {
                                    $busID = $busDriver['busID'];
                                }
                                echo "<tr>
                                    <td>".$row['userID']."</td>
                                    <td>".$row['firstname'].' '.$row['lastname']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$busID."</td>
                                    <td>".$routeTkn."</td>"; ?>
                                        
                                    </tr>
                            <?php   }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card edit">
                    <form action="" method="POST">
                        <h3>Assign Route and Bus</h3>
                        <div class="input">
                            <label>Select route | Driver Only*</label>
                            <select name="route">
                            <option disabled selected>Select route...</option>
                                <?php while($row = $driverRoute->fetch_assoc()): ?>
                                    <option value="<?=$row['routeID']?>"><?=$row['name']?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <button type="submit" name="submit">Assign</button>
                        <div class="errorText">
                            <?=$_SESSION['msg'] ?? '' ?>
                            <?php unset($_SESSION['msg']) ?>
                        </div>
                    </form>
            </div>
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