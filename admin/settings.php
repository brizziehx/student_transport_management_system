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

    $dateTime = explode(' ', $row['createdAt']);
    
    $date = explode('-', $dateTime[0]);
    $time = explode(':', $dateTime[1]);

    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    $hour = $time[0];
    $min = $time[1];
    $sec = $time[2];

    $timestamp = mktime($hour, $min, $sec, $month, $day, $year);


    include('update.php');

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
 
    <style>
        table {
            width: 50%;
            border: none;
        }
        table td {
            text-align: left;
            border: none;
        }
        table tr:hover {
            box-shadow: none;
        }
        .cards .btn {
            background: #695CFE;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cards .btn h3 {
            margin: 0;
            padding: 0;
        }
        .cards .btn:hover {
            background: #8378f3;
            color: #fff;
        }
    </style>
    <title>Dashboard - Profile Settings</title>
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
                        <a href="settings.php" class="active">
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
            <div href="#" class="card xxpand ypand2" >
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Account Information</li>
                    </ol>
                </nav>
                <!-- <h3>Profile</h3> -->
                <div class="details">
                    
                    <table>
                        <tr>
                            <td>Full Name:</td><td><b><?=$row['firstname']. ' '.$row['lastname']?></b></td>
                        </tr>
                        <tr>
                            <td>Role:</td><td><b><?=$row['usertype'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Phone Number:</td><td><b><?=$row['phone'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Email Address:</td><td><b><?=$row['email'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Gender:</td><td> <b><?=$row['gender'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Member Since:</td><td><b><?=date('jS F Y', $timestamp) ?>&nbsp; &nbsp; | &nbsp; &nbsp;<?=$hour.' : '.$min.' : '.$sec ?></b></td>
                        </tr>
                        <tr>
                            <td>Last Account Update:</td><td><b><?=date('jS F Y', $timestamp2) ?>&nbsp; &nbsp; | &nbsp; &nbsp;<?=$hour2.' : '.$min2.' : '.$sec2 ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <img class="adimg" src="../uploads/<?=$row['image']?>" alt="">
            </div>
            <a href="editprofile.php" class="card btn">
                <h3 align="center">Edit Profile</h3>
            </a>
        </div>
        
        <footer>
            <p>School Transport Management System &copy; 2023. All Rights Reserved</p>
        </footer>
    </main>
    <script src="../js/script.js"></script>
</body>
</html>
