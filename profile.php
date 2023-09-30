<?php
     require('db/db.php');
     require('auth.php');
     include('admin/greet.php');


    $user = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $user->fetch_assoc();


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

    $drivers = $conn->query("SELECT * FROM schoolbus WHERE driverID = {$row['userID']}");
    $row2 = $drivers->fetch_assoc();

    $route = $conn->query("SELECT * FROM route WHERE routeID = '{$row2['routeID']}'");
    $rowRoute = $route->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ustyle.css">
    <!-- ========= BOXICONS  CSS ========== -->
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <title>Profile | School Transport Management System</title>
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

        .adimg {
            width: 100%;
            height: 270px;
            object-fit: cover;
        }
        main .btn {
            background: crimson;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        main .btn:hover {
            background:#7e0820;
        }
       
    </style>
</head>
<body>
<script src="js/lib/vanilla-toast.min.js"></script>
<?=$_SESSION['msg'] ?? '' ?>
<?php unset($_SESSION['msg']) ?>
    <header class="grid user">
        <h2>School Transport Management System</h2>

        <nav class="user-nav">
            <div class="user">
                <img src="uploads/<?=$row['image']?>" >
                <span class="username"><?php echo $row['firstname'].' '.$row['lastname'] ?><span class="utype"><?=$row['usertype']?></span></span>
            </div>

            <a class="" href="index.php"><i class="bx bx-home"></i>Home</a>
            <a class="active" href="profile.php"><i class="bx bx-user"></i>Profile</a>
            <a class="logout" href="logout.php?logout_id=<?php echo $row['userID'] ?>"><i class="bx bx-log-out"></i>Logout </a>
        </nav>
    </header>
    <main class="grid cards">
        
        <div class="card xxpand ypand2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
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
                            <td>Route:</td><td> <b><?=$rowRoute['name'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Member Since:</td><td><b><?=date('jS F Y', $timestamp) ?>&nbsp; &nbsp; | &nbsp; &nbsp;<?=$hour.' : '.$min.' : '.$sec ?></b></td>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <div class="card">
                <img class="adimg" src="uploads/<?=$row['image']?>" alt="">
            </div>
            <a  href="changepwd.php" class="card btn">
                <h3 align="center">Change Password</h3>
            </a>
        </div>

    </main>
</body>
</html>