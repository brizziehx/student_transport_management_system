<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    $studentID = $_GET['id'];

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
 
    <style>
        main .card p {
            margin: 0;
        }
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
        .button {
            display: flex;
            justify-content: center;
            /* display: inline-block; */
            align-items: center;
        }
        .btn {
            display: flex;
            align-items: center;
            font-weight: bold;
            padding: 5px 10px;
            background: #000;
            border-radius: 5px;
            color: #fff;
            margin: 10px;
            cursor: pointer;
        }
        
        .btn i {
            margin-right: 5px;
        }
        input {
            border: none;
            outline: none;
            
        }
    </style>
    <title>Dashboard - Student Details</title>
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
            <div href="#" class="card xxxpand ypand2" >
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="students.php">All Students </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student Information</li>
                    </ol>
                </nav>
                <!-- <h3>Profile</h3> -->
                <div class="details">
                    
                    <?php  
                       if(isset($_POST['month'])):
                            if(!empty($_POST['month'])) {
                                $monthYear = $_POST['month'];
                            
                                $month = explode('-', $monthYear);
                                // echo $month[1];

                                $timestamp = mktime(0, 0, 0, $month[1], 28, $month[0]);

                                $now = $month[1];
                                $year = $month[0];

                                // echo date('F Y', $timestamp); 

                                $result = $conn->query("SELECT * FROM student WHERE studentID = {$studentID}");
                                $row2 = $result->fetch_assoc();

                                $loc = $conn->query("SELECT * FROM stop WHERE locationID = {$row2['locationID']}");
                                $row3 =$loc->fetch_assoc();

                                $route = $conn->query("SELECT * FROM route WHERE routeID = '{$row3['routeID']}'");
                                $row4 = $route->fetch_assoc();

                                $paye = 0;
                                
                                $pay = $conn->query("SELECT * FROM payment WHERE studentID = {$studentID} AND (month(date) = $now AND year(date) = $year)");
                                while($row = $pay->fetch_assoc()) {
                                    
                                    $paye = $paye + $row['amount'];

                                }

                                $balance = $row4['fair'] - $paye;

                                if($paye > 0 && $paye < $row4['fair']) {
                                    $status = "<span class='status3'>Incomplete</span>";
                                } elseif($paye > 0 && $paye >= $row4['fair']) {
                                    $status = "<span class='status'>Complete</span>";
                                }
                                else {
                                    $status = "<span class='status2'>Not paid</span>";
                                }
                    ?>
                                <table>
                                    <tr>
                                        <td>Full Name:</td><td><b><?=$row2['firstname']. ' '.$row2['lastname']?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Parent:</td><td><b><?=$row2['parentName'] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number:</td><td><b><?=$row2['phone'] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number II:</td><td><b><?=$row2['phone2'] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Amount Per month:</td><td><b><?=number_format($row4['fair'], 2, '.', ',') ?> /= Tsh  | For <?=date('F Y', $timestamp)?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Amount Paid:</td><td><b><?=number_format($paye, 2, '.', ',') ?> /= Tsh</b></td>
                                    </tr>
                                    <tr>
                                        <td>Outstanding Amount:</td><td> <b><?=number_format($balance, 2, '.', ',') ?> /= Tsh</b></td>
                                    </tr>
                                    <tr>
                                        <td>Payment Status:</td><td><b><?=$status?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Select month:</td>
                                        <td>
                                                <form action="" method="POST">
                                                    <input type="month" name="month">
                                                    <button class="btn" type="submit">View</button>
                                                </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <div class="button">
                                                <a class="btn" href="print.php?id=<?=$_GET['id']?>&month=<?=$now?>&year=<?=$month[0] ?>"><i class="bx bx-detail"></i>View Report</a>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                
                        <?php  } else { ?>
                                <p style="color: #f00">Make sure you select the month before viewing</p>
                                <div class="button">
                                    <a class="btn" href="details.php?id=<?=$_GET['id']?>"><i class='bx bx-undo'></i>Go Back</a>
                                </div>
                    <?php   }
                       else:
                    ?>
                    <?php
                        $now = date('m');
                        $year = date('Y');

                        $result = $conn->query("SELECT * FROM student WHERE studentID = {$studentID}");
                        $row2 = $result->fetch_assoc();

                        $loc = $conn->query("SELECT * FROM stop WHERE locationID = {$row2['locationID']}");
                        $row3 =$loc->fetch_assoc();

                        $route = $conn->query("SELECT * FROM route WHERE routeID = '{$row3['routeID']}'");
                        $row4 = $route->fetch_assoc();

                        $paye = 0;

                        $pay = $conn->query("SELECT * FROM payment WHERE studentID = {$studentID} AND (month(date) = $now AND year(date) = $year)");
                        while($row = $pay->fetch_assoc()) {
                            
                            $paye = $paye + $row['amount'];

                        }

                        $balance = $row4['fair'] - $paye;

                        if($paye > 0 && $paye < $row4['fair']) {
                            $status = "<span class='status3'>Incomplete</span>";
                        } elseif($paye > 0 && $paye >= $row4['fair']) {
                            $status = "<span class='status'>Complete</span>";
                        }
                        else {
                            $status = "<span class='status2'>Not paid</span>";
                        }


                    ?>
                    
                    <table>
                        <tr>
                            <td>Full Name:</td><td><b><?=$row2['firstname']. ' '.$row2['lastname']?></b></td>
                        </tr>
                        <tr>
                            <td>Parent:</td><td><b><?=$row2['parentName'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Phone Number:</td><td><b><?=$row2['phone'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Phone Number II:</td><td><b><?=$row2['phone2'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Amount Per month:</td><td><b><?=number_format($row4['fair'], 2, '.', ',') ?> /= Tsh  | For <?=date('F Y')?></b></td>
                        </tr>
                        <tr>
                            <td>Amount Paid:</td><td><b><?=number_format($paye, 2, '.', ',') ?> /= Tsh</b></td>
                        </tr>
                        <tr>
                            <td>Outstanding Amount:</td><td> <b><?=number_format($balance, 2, '.', ',') ?> /= Tsh</b></td>
                        </tr>
                        <tr>
                            <td>Payment Status:</td><td><b><?=$status?></b></td>
                        </tr>
                        <tr>
                            <td>Select month:</td>
                            <td >
                                    <form action="" method="POST">
                                        <input type="month" name="month">
                                        <button class="btn" type="submit">View</button>
                                    </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <div class="button">
                                    <a class="btn" href="print.php?id=<?=$_GET['id']?>&month=<?=$now?>&year=<?=date('Y')?>"><i class="bx bx-detail"></i>View Report</a>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <?php endif ?>
                    
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
