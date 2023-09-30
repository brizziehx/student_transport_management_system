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
    <title>Home | School Transport Management System</title>
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
            <a class="" href="profile.php"><i class="bx bx-user"></i>Profile</a>
            <a href="logout.php?logout_id=<?php echo $row['userID'] ?>"><i class="bx bx-log-out"></i>Logout</a>
        </nav>
    </header>
    <main class="grid">
        <div class="pand2 card">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                </ol>
            </nav>
            <p>
                <?=$greetings?> <?=$_SESSION['driver']?>! <br> Welcome to your Dashboard
            </p>
        </div>

        <a href="route.php" class="card">
            <p class="flex"><b>My Route</b><i class="bx bx-trip icon"></i></p>
            <?php $drivers = $conn->query("SELECT * FROM schoolbus WHERE driverID = {$row['userID']}") ?>
            <?php $row2 = $drivers->fetch_assoc(); ?>
            <h1><?=$drivers->num_rows?></h1>
        </a>

        <a class="card" href="pick.php?routeID=<?=$row2['routeID']?>">
            <p class="flex"><b>Pickup Points</b><i class="bx bx-map icon"></i></p>

             <?php $result = $conn->query("SELECT * FROM stop WHERE routeID = '{$row2['routeID']}'"); ?>
            <h1><?=$result->num_rows?></h1>
        </a>

        


        <a href="parents.php" class="card">

             <p class="flex"><b>Parents</b><i class="bx bx-user icon"></i></p>
             
             
             <?php 
                $count = 0;
                $bus = $conn->query("SELECT * FROM schoolbus WHERE driverID = {$row['userID']}");
                $busrow = $bus->fetch_assoc();
                $location = $conn->query("SELECT * FROM stop WHERE routeID = '{$busrow['routeID']}'");
                while($rowLoc = $location->fetch_assoc()):
                    $pay = $conn->query("SELECT DISTINCT studentID FROM payment WHERE month(date) = month(now()) AND year(date) = year(now())");
                    while($row2 = $pay->fetch_assoc()):
                        $students = $conn->query("SELECT * FROM student WHERE studentID = {$row2['studentID']} AND  locationID = {$rowLoc['locationID']}");
                        while($rowStudent = $students->fetch_assoc()):
            ?>
                            <?php $count++; ?>
            <?php       endwhile;
                    endwhile;
                endwhile;
                
            ?>
            <h1><?=$count?></h1>
        </a>
    </main>
</body>
</html>