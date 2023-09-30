<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }
    
    $bus_id = $_GET['busID'];

    include('greet.php');
    if(isset($_POST['submit'])) {
        $bus_type = $_POST['bustype'];
        $driver = $_POST['driver'] ?? '';
        $route = $_POST['route'] ?? '';

        $bus_type = trim($bus_type);

        $bus_type = htmlspecialchars($bus_type);

        $currbus = $conn->query("SELECT * FROM schoolbus WHERE busID = '{$bus_id}'");
        $busrow = $currbus->fetch_assoc();

        $_SESSION['bus'] = $busrow['busID'];

        if(!empty($bus_type) && !empty($driver) && !empty($route)) {
            $sql = $conn->query("SELECT * FROM schoolbus WHERE NOT busID = '{$busrow['busID']}' AND driverID = $driver");
            $sql2 = $conn->query("SELECT * FROM schoolbus WHERE NOT busID = '{$busrow['busID']}' AND routeID = '{$route}'");
            if($sql->num_rows > 0) {
                $_SESSION['msg'] = "<script>vt.error('This driver has already been assigned to another route', { title: 'Error', duration: 2500, position: 'top-center'})</script>";
            } elseif($sql2->num_rows > 0) {
                $_SESSION['msg'] = "<script>vt.error('This route has already been assigned to another driver', { title: 'Error', duration: 2500, position: 'top-center'})</script>";
            } else {
                $notification = $_SESSION['bus']." has been updated successfully";
                $insert = $conn->query("UPDATE schoolbus SET bustype = '{$bus_type}' , driverID = {$driver}, routeID = '{$route}' WHERE busID = '{$bus_id}'");
                if($insert == true) {
                    $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");
                    $_SESSION['msg'] = "<script>vt.success('Bus has been updated successfully', { duration: 2500, position: 'top-center'})</script>";
                }
            }
        } else {
            $_SESSION['msg'] = "<script>vt.error('All input fields are required', { title: 'Error', duration: 2500, position: 'top-center'})</script>";
        }
    }

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();

    $drivers = $conn->query("SELECT * FROM users WHERE usertype = 'Driver'");
    $routes = $conn->query("SELECT * FROM route");

    $result = $conn->query("SELECT * FROM schoolbus WHERE busID = '{$bus_id}'");
    $bus = $result->fetch_assoc();
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
 
    <title>Dashboard - Add Bus</title>
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
                        <a href="routes.php" class="">
                            <i class="bx bx-trip icon"></i>
                            <span class="text nav-text">Routes</span>
                        </a>
                    </li>


                    <li class="nav-links">
                        <a href="busses.php" class="active">
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
                        <li class="breadcrumb-item" aria-current="page"><a href="busses.php">All Buses</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=$bus['busID']?></li>
                    </ol>
                </nav>
                
                <div class="table">

                <table>

                    <thead>
                        <tr>
                        <th>Bus ID</th>
                        <th>Bus Type</th>
                        <th>Driver ID</th>
                        <th>Route ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                        $result = $conn->query("SELECT * FROM schoolbus WHERE busID = '{$bus_id}'");
                        while($row = $result->fetch_array()){ ?>
                            <tr>
                                <td><?=$row['busID']?></td>
                                <td><?=$row['bustype']?></td>
                                <td><?=$row['driverID']?></td>
                                <td><?=$row['routeID']?></td>
                            </tr>
                         <?php   }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
  
            </div>
            <div class="card pand ypand edit">
                <form class="register" method="POST" action="">
                    <h3>Edit <?=$bus['busID']?></h3>
                    
                    <div class="inputs">
                        <div class="input">
                            <label>Bus ID</label>
                            <input type="text" disabled value="<?=$bus['busID']?>">
                        </div>
                        <div class="input">
                            <label>Bus Type</label>
                            <input type="text" name="bustype" value="<?=$bus['bustype']?>" placeholder="Bus Type">
                        </div>
                    </div>
                    <div class="input">
                        <label>Driver</label>
                        <select name="driver">
                            <option selected disabled>Select driver...</option>
                            <?php if($drivers->num_rows > 0): 
                                while($row =$drivers->fetch_assoc()): ?>
                                    <option value="<?=$row['userID']?>"><?=$row['firstname']?> <?=$row['lastname']?></option>
                                <?php endwhile; endif; ?>
                        </select>
                    </div>
                    <div class="input">
                        <label>Route</label>
                        <!-- <input type="text" name="finish" value="" placeholder="Route"> -->
                        <select name="route">
                            <option selected disabled>Select route....</option>
                            <?php if($routes->num_rows > 0):
                                while($row = $routes->fetch_assoc()): ?>
                                    <option value="<?=$row['routeID']?>"><?=$row['name']?></option>
                            <?php endwhile; endif; ?>
                        </select>
                    </div>
                    
                    <button type="submit" name="submit" >Edit Bus</button>
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