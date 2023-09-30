<?php 

    session_start();
    require('../db/db.php');

    $routeID = $_GET['routeID'];

    $result = $conn->query("SELECT * FROM route WHERE routeID = '$routeID'");
    $route = $result->fetch_assoc();
    
    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();


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
 
    <title>Dashboard - Location</title>
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

            <div href="#" class="card xxxpand">
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="routes.php">Routes</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=$route['name']?></li>
                    </ol>
                </nav>
                <?=$_SESSION['msg'] ?? '' ?>
                <?php unset($_SESSION['msg']) ?>
                <?php unset($_SESSION['name']) ?>
                
                <p class="flex"><b>All Stops</b><a href="addstop.php?routeID=<?=$_GET['routeID']?>"><i class="bx bx-location-plus icon"></i></a></p>
                
                <?php 
                    $result = $conn->query("SELECT * FROM stop WHERE routeID = '$routeID' ORDER BY time ASC");
                    if($result->num_rows > 0) {
                ?>

            <div class="table">

                <table>
                    <thead>
                        <tr>
                        <th>Location ID</th>
                        <th>Location Name</th>
                        <th>Student(s)</th>
                        <th>Pick up Time</th>
                        <th>Drop off Time</th>
                        <th>Route ID</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                            while($row = $result->fetch_array()){ 
                                $students = $conn->query("SELECT * FROM student WHERE locationID = '{$row['locationID']}'");?>
                                <tr>
                                    <td><?=$row['locationID']?></td>
                                    <td><a href="student.php?routeID=<?=$routeID?>&locationID=<?=$row['locationID']?>"><?=$row['locationName']?></a></td>
                                    <td><?=$students->num_rows?></td>
                                    <td><?=$row['time']?></td>
                                    <td><?=$row['time2']?></td>
                                    <td><?=$row['routeID']?></td>
                                    
                                    <td>
                                        <a class=btn-edit onclick="if(confirm('Are you sure you want to edit this location?') === false) { event.preventDefault() }" href=editstop.php?routeID=<?=$row['routeID']?>&locationID=<?=$row['locationID']?>><i class="bx bx-edit icon"></i></a>
                                        <a class=btn-delete onclick="if(confirm('Are you sure you want to delete this location?') === false) { event.preventDefault() }" href=deletestop.php?locationID=<?=$row['locationID']?>><i class="bx bx-trash icon"></i></a>
                                    </td>
                                    </tr>
                        
                         <?php } ?>
                         
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <h3 style="margin: 10px; text-align:center">This route has no location to stop yet</h3>
            <?php } ?>
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