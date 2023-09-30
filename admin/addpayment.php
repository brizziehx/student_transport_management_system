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

    if($row5['studentID'] !== $childID) {
        header("Location: 404.php");
    }

    $loc = $conn->query("SELECT * FROM stop WHERE locationID = {$row5['locationID']}");
    $rowloc =$loc->fetch_assoc();

    $route = $conn->query("SELECT * FROM route WHERE routeID = '{$rowloc['routeID']}'");
    $rowroute = $route->fetch_assoc();

    $pae = 0;
    $nou = date('m');
    $paid = $conn->query("SELECT * FROM payment WHERE studentID = {$row5['studentID']} AND (month(date) = $nou AND year(date) = year(now()))");
    while($row7 = $paid->fetch_assoc()) {
        
        $pae = $pae + $row7['amount'];

    }

    $balance = $rowroute['fair'] - $pae;


    $errors = array('date'=>'', 'amount'=>'');

    if(isset($_POST['submit'])) {

        $pae = 0;
        $paid = $conn->query("SELECT * FROM payment WHERE studentID = {$row5['studentID']} AND (month(date) = month('{$_POST['date']}') AND year(date) = year(now()))");
        while($row7 = $paid->fetch_assoc()) {
            
            $pae = $pae + $row7['amount'];
    
        }

        $balance = $rowroute['fair'] - $pae;
        
        $date = $_POST['date'];
        $amount = $_POST['amount'];


        $amount = addslashes($amount);

       if(empty($date)) {
            $errors['date'] = "Date is required";
       } else {
            $date = trim($date);
            $_SESSION['date'] = $date;
       }

       if(empty($amount)) {
            $errors['amount'] = "Amount paid is required";
       } else {
            if(!preg_match('/^[\d]{4,}$/', $amount)) {
                $errors['amount'] = "Minimum amount is 1,000 tsh";
            } elseif ($amount > $rowroute['fair']) {
                $errors['amount'] = "Maximum amount is ".number_format($rowroute['fair'], 2, '.', ',')." Tsh";
            } elseif($amount > $balance) {

                $dateEx = explode('-', $date);
                $yr = $dateEx[0];
                $mn = $dateEx[1];
                $dy = $dateEx[2];
        
                $timestamp = mktime(0,0,0,$mn,$dy,$yr);
                
                $errors['amount'] = "Outstanding amount for ".date('F', $timestamp)." is ".number_format($balance, 2, '.', ',')." Tsh";
            } else {
                $amount = trim($amount);
                $_SESSION['amount'] = $amount;
            }
       }

       if(!array_filter($errors)) {
            $insert = $conn->query("INSERT INTO payment(amount, date, studentID) VALUES ($amount, '$date', {$row5['studentID']})");
            if($insert == true) {
                unset($_SESSION['amount']);
                unset($_SESSION['date']);
                
                $_SESSION['msg'] = "<script>vt.success('Amount has been added successfully', {position: 'top-center'})</script>";
            }
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
 
    <title>Dashboard - Add Payment</title>
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

            <?php

                $loc = $conn->query("SELECT * FROM stop WHERE locationID = {$row3['locationID']}");
                $row2 =$loc->fetch_assoc();

                $route = $conn->query("SELECT * FROM route WHERE routeID = '{$row2['routeID']}'");
                $row4 = $route->fetch_assoc();

                $paye = 0;
                $now = date('m');
                $pay = $conn->query("SELECT * FROM payment WHERE studentID = {$row3['studentID']} AND month(date) = $now");
                while($row5 = $pay->fetch_assoc()) {
                    
                    $paye = $paye + $row5['amount'];

                }


                // if($paye < $row4['fair']):
            ?>


            <div class="card pand ypand edit">
                <form class="register" method="POST" action="" enctype="multipart/form-data">
                    <h3>Payment Form</h3>
                    <div class="input">
                        <label>Date</label>
                        <input type="date" name="date" value="<?=$_SESSION['date'] ?? ''?>">
                    </div>
                    <p class="errorText"><?=$errors['date']?></p>
                    <div class="input">
                        <label>Amount Paid in Tsh</label>
                        <input type="number" name="amount" value="<?=$_SESSION['amount'] ?? ''?>" placeholder="Amount">
                    </div>
                    <p class="errorText"><?=$errors['amount']?></p>
                    <button type="submit" name="submit" >Submit</button>
                    <div class="errorText">
                        <?=$_SESSION['msg'] ?? '' ?>
                        <?php unset($_SESSION['msg']) ?>
                    </div>
                </form>
            </div>
            
            <?php //else: ?>

                <!-- <div class="card pand">
                    <h3 style="display: flex; justify-content:center; align-items:center; height: 100%">Payment for <?=date('F')?> has been cleared</h3>
                </div> -->

            <?php //endif ?>

        </div>


        <?=$_SESSION['msg'] ?? '' ?>
        <?php unset($_SESSION['msg']) ?>
        <footer>
            <p>School Transport Management System &copy; 2023. All Rights Reserved</p>
        </footer>
    </main>
    <script src="../js/script.js"></script>
</body>
</html>