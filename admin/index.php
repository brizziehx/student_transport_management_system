<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();

    $users = $conn->query("SELECT * FROM users WHERE NOT usertype = '{$row['usertype']}'");

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
 
    <title>Dashboard - Home</title>
    <style>
        .none::after {
            display: none;
        }
    </style>
</head>
<body>
<script src="../js/lib/vanilla-toast.min.js"></script>
    <?=$_SESSION['msg'] ?? '' ?>    
    <?php unset($_SESSION['msg']) ?>
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
                        <a href="index.php" class="active">
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
            <div href="#" class="card xxpand">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                    </ol>
                </nav>
                <p>Welcome <?=$row['usertype']?></p>
                
            </div>
    
            
    
            <a href="notification.php" class="card  ypand">
                <?php $nots = $conn->query("SELECT * from nots ORDER BY id DESC LIMIT 8"); ?>
                <p class="flex"><b>Notifications</b><i class="bx bx-notification icon"></i></p>

                <?php  
                    if($nots->num_rows > 0): 
                        while($row = $nots->fetch_assoc()):
                ?>
                    <p><i style="font-size: 20px;" class="bx bx-bell icon"></i><?=$row['notification']?></p>
                <?php endwhile; else: ?>
                    <p>There's no notification at this time</p>
                <?php endif; ?>
                
            </a>

            <?php $clients = $users->num_rows < 2 ? 'Driver' : 'Drivers'; ?>

            <a href="users.php" class="card">
                <p class="flex"><b><?=$clients?></b><i class="bx bx-user icon"></i></p>
                <h1><?=$users->num_rows?></h1>
            </a>

            <div href="#" class="card pand4">
                <?php
                    $students = $conn->query("SELECT * FROM student");

                    $header = $students->num_rows < 2 ? 'Student' : 'Students';
                    $paid = 0;
                    $pay = $conn->query("SELECT DISTINCT studentID FROM payment WHERE month(date) = month(now()) AND year(date) = year(now())");
                    while($row2 = $pay->fetch_assoc()):
                        $cleared = $conn->query("SELECT * FROM student WHERE studentID = {$row2['studentID']}");
                        while($one = $cleared->fetch_assoc()):
                            $paid++;
                        endwhile;
                    endwhile;
                    $result = $conn->query("SELECT * FROM student WHERE NOT EXISTS(SELECT studentID FROM payment WHERE student.studentID = payment.studentID AND (month(date) = month(now()) AND year(date) = year(now())))");
                    $unpaid = $result->num_rows;
                    $all_students = $students->num_rows;

                    if($all_students > 0):
                ?>
                <p class="flex"><b><?=$header?></b><a href="students.php"><i class="bx bx-child icon"></i></a></p>

                
                <div class="student">
                    <h1><?=$all_students?></h1>
                    <div class="payment">
                        <strong>Payment Status</strong>
                            <span><a class="links" href="paid.php">Paid</a>  <span class="head"><strong><?=$paid?></strong></span></span>
                            <span><a class="links" href="unpaid.php">Unpaid</a>  <span class="head"><strong><?=$unpaid ?></strong></span></span>
                    </div>
                </div>
                <?php else: ?>
                    <p class="flex"><b><?=$header?></b><a href="students.php"><i class="bx bx-child icon"></i></a></p>

                    <div class="student">

                    <h1 class="none"><?=$all_students?></h1>

                </div>

                <?php endif ?>
            </div>

            <a href="routes.php" class="card pand3">
                <?php $route = $conn->query("SELECT * FROM route") ?>
                <p class="flex"><b>Routes</b><i class="bx bx-trip icon"></i></p>
                <h1><?=$route->num_rows?></h1>
            </a>

            <div class="card">
                <p class="flex"><b>Bus Stops</b><i class="bx bx-map icon"></i></p>
                <?php $stops = $conn->query("SELECT * FROM stop") ?>
                <h1><?=$stops->num_rows?></h1>
            </div>

            <a class="card" href="busses.php">
                <p class="flex"><b>School Buses</b><i class="bx bx-bus-school icon"></i></p>
                <?php $bus = $conn->query("SELECT * FROM schoolbus") ?>
                <h1><?=$bus->num_rows?></h1>
            </a>
    
            <a href="drivers.php" class="card">
                <p class="flex"><b>Drivers + Bus</b><i class="bx bx-bus icon"></i></p>
                <?php $drivers = $conn->query("SELECT * FROM users WHERE usertype = 'Driver'") ?>
                <h1><?=$drivers->num_rows?></h1>
            </a>
            

        </div>
        
        <footer>
            <p>School Transport Management System &copy; 2023. All Rights Reserved</p>
        </footer>
    </main>
    <script src="../js/script.js"></script>
</body>
</html>
