<?php
    require('db/db.php');
    require('auth.php');
    include('admin/greet.php');

    $user = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $user->fetch_assoc();
    
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
    <title>Parents | School Transport Management System</title>
    <style>
        table {
            width: 30%;
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
<header class="grid user">
        <h2>School Transport Management System</h2>

        <nav class="user-nav">
            <div class="user">
                <img src="uploads/<?=$row['image']?>" >
                <span class="username"><?php echo $row['firstname'].' '.$row['lastname'] ?><span class="utype"><?=$row['usertype']?></span></span>
            </div>

            <a class="active" href="index.php"><i class="bx bx-home"></i>Home</a>
            <a href="profile.php"><i class="bx bx-user"></i>Profile</a>
            <a href="logout.php?logout_id=<?php echo $row['userID'] ?>"><i class="bx bx-log-out"></i>Logout</a>
        </nav>
    </header>
    <main class="grid">

       <div class="card uxpand">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Route</li>
                </ol>
            </nav>
            <?php 
                           
                $bus = $conn->query("SELECT * FROM schoolbus WHERE driverID = {$row['userID']}");
                $busrow = $bus->fetch_assoc();
                $route = $conn->query("SELECT * FROM route WHERE routeID = '{$busrow['routeID']}'");
                $row2 = $route->fetch_assoc();
                $location = $conn->query("SELECT * FROM stop WHERE routeID = '{$busrow['routeID']}'");
                        
            ?>
            <div class="details">
                    
                    <table>
                        <tr>
                            <td>My Route:</td><td> <b><?=$row2['name'] ?></b></td>
                        </tr>
                        <tr>
                            <td>Number of Bus Stops:</td><td><b><?=$location->num_rows?></b></td>
                        </tr>
                        <tr>
                            <td>Students in my route:</td>

                            <td><b>
                            <?php
                            $count = 0;
                                while($rowLoc = $location->fetch_assoc()):
                                    $pay = $conn->query("SELECT DISTINCT studentID FROM payment WHERE month(date) = month(now())");
                                    while($row2 = $pay->fetch_assoc()):
                                        $students = $conn->query("SELECT * FROM student WHERE studentID = {$row2['studentID']} AND locationID = {$rowLoc['locationID']}");
                                        while($rowStudent = $students->fetch_assoc()):
                                            $count++;
                                        endwhile;
                                    endwhile;
                                endwhile
                            ?>
                            <?=$count?></b></td>
                        </tr>
                        
                        
                    </table>
                </div>
       </div>
        
    </main>
</body>
</html>