<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $admin->fetch_assoc();



    if(isset($_POST['submit'])) {
        $routeID = htmlentities($_POST['routeID']);
        $routeName = htmlentities($_POST['name']);
        $start = htmlentities($_POST['start']);
        $finish = htmlentities($_POST['finish']);
        $fair = htmlentities($_POST['fair']);

        $routeID =trim($routeID);
        $routeName = trim($routeName);
        $start = trim($start);
        $finish = trim($finish);
        $fair = trim($fair);

        $_SESSION['id'] = $routeID;
        $_SESSION['name'] = $routeName;
        $_SESSION['start'] = $start;
        $_SESSION['finish'] = $finish;
        $_SESSION['fair'] = $fair;

        $notification = $_SESSION['name']."\'s Route has been added successfully";

        if(!empty($routeID) && !empty($routeName) && !empty($start) && !empty($finish) && !empty($fair)) {
            if(preg_match('/^[A-Z]{2,5}$/', $routeID)) {
                if(preg_match('/^[A-Z][a-zA-Z ]{2,20}$/', $routeName)) {
                    if(preg_match('/^[A-Z][a-zA-Z ]{2,}$/', $start)) {
                        if(preg_match('/^[A-Z][a-zA-Z ]{2,}$/', $finish)) {
                            if(preg_match('/^[\d]{5,}$/', $fair)) {
                                $route = $conn->query("SELECT * FROM route WHERE routeID = '$routeID'");

                                if($route->num_rows > 0) {
                                    $_SESSION['msg'] = "<script>vt.error('This route already exist! Please choose another one', { title: 'Error', position: 'top-center'})</script>";
                                } else {
                                    $sql = $conn->query("INSERT INTO route (routeID, name, start, finish, fair) VALUES ('$routeID', '$routeName', '$start', '$finish', '$fair')");
                                    if($sql == true) {
                                        unset($_SESSION['id']);
                                        unset($_SESSION['name']);
                                        unset($_SESSION['start']);
                                        unset($_SESSION['finish']);
                                        unset($_SESSION['fair']);

                                        $conn->query("INSERT INTO nots (notification) VALUES ('{$notification}')");

                                        $_SESSION['msg'] = "<script>vt.success('New Route has been added successfully!', {position: 'top-center'})</script>";
                                    }
                                }
                            } else {
                                $_SESSION['msg'] = "The cost must be a number and not less than 10,000/- tsh";
                            }
                        } else {
                            $_SESSION['msg'] = "Final destination point must start with an uppercase letters and must be greater than 3 letters";
                        }
                    } else {
                        $_SESSION['msg'] = "Starting point must start with an <br> uppercase letters and must be greater <br> than 2 letters";
                    }
                } else {
                    $_SESSION['msg'] = "Route name must start with an <br> uppercase letters and must be greater <br> than 2 letters";
                }
            } else {
                $_SESSION['msg'] = "RouteID must contain not less than 2 uppercase letters and not above 5 letters";
            }
        } else {
            $_SESSION['msg'] = "All input fields are required";
        }



    }

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
                        <li class="breadcrumb-item active" aria-current="page">Add Route</li>
                    </ol>
                </nav>
                
                <div class="table">

                <table>
                    <?php if(isset($_SESSION['msg2'])): ?>
                        <caption>
                            <?=$_SESSION['msg2'] ?? '' ?>
                            <?php unset($_SESSION['msg2']) ?>
                            <?php unset($_SESSION['name']) ?>
                        </caption>
                    <?php endif ?>
                    <thead>
                        <tr>
                        <th>Route ID</th>
                        <th>Route Name</th>
                        <th>Start</th>
                        <th>Finish</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                        $result = $conn->query("SELECT * FROM route");
                        while($row = $result->fetch_array()){

                            $fair = number_format($row['fair'], 2, '.', ',');
                            $routeName = $row['name']; ?>
                            <tr>
                                <td><?=$row['routeID']?></td>
                                <td><a href="stops.php?routeID=<?=$row['routeID']?>"><?=$routeName?></a></td>
                                <td><?=$row['start']?></td>
                                <td><?=$row['finish']?></td>
                                </tr>
                         <?php   }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        
        </div>
        <div class="card pand edit">
        <form class="register" method="POST" action="" enctype="multipart/form-data">
                    <h3>Route Registration Form</h3>
                    
                    <div class="inputs">
                        <div class="input">
                            <label for="id">Route ID</label>
                            <input type="text" name="routeID" value="<?=$_SESSION['id'] ?? ''?>" placeholder="Route ID">
                        </div>
                        <div class="input">
                            <label for="name">Route Name</label>
                            <input type="text" name="name" value="<?=$_SESSION['name'] ?? ''?>" placeholder="Route Name">
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="start">Start</label>
                            <input type="text" name="start" value="<?=$_SESSION['start'] ?? ''?>" placeholder="Start">
                        </div>
                        <div class="input">
                            <label for="finish">Finish</label>
                            <input type="text" name="finish" value="<?=$_SESSION['finish'] ?? ''?>" placeholder="Finish">
                        </div>
                    </div>
                    <div class="input">
                        <label for="cost">Cost</label>
                        <input type="number" name="fair" value="<?=$_SESSION['fair'] ?? ''?>" placeholder="Fair">
                    </div>
                    <button type="submit" name="submit" >Add Route</button>
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