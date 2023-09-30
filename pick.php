<?php
    require('db/db.php');
    require('auth.php');
    include('admin/greet.php');

    $routeID = htmlentities($_GET['routeID']);

    $user = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row = $user->fetch_assoc();




    // $students = $conn->query("SELECT * FROM student WHERE userID = {$_SESSION['unique_id']}");

    
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
    <title>Pickup points | School Transport Management System</title>

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

       <div class="card uxpand" style="height: 500px; overflow-y:auto">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pickup Points</li>
                </ol>
            </nav>
            <p class="flex"><b>Pickup Points</b><i class="bx bx-map icon"></i></p>
            <div class="table">

                <table>
                <?php if(isset($_SESSION['msg']) || isset($_SESSION['name'])): ?>
                        <caption>
                            <?=$_SESSION['msg'] ?? '' ?>
                            <?php unset($_SESSION['msg']) ?>
                            <?php unset($_SESSION['name']) ?>
                        </caption>
                    <?php endif ?>
                    <thead>
                        <tr>
                            <th>Route Name</th>
                            <th>Location Name</th>
                            <th>Student Name</th>
                            <th>Pick up Time</th>
                            <th>Drop off Time</th>
                            <th>Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $result = $conn->query("SELECT * FROM stop WHERE routeID = '{$routeID}'");
                        while($rows = $result->fetch_assoc()):
                        
                        $pay = $conn->query("SELECT DISTINCT studentID FROM payment WHERE month(date) = month(now())");
                        while($row2 = $pay->fetch_assoc()):

                        $students = $conn->query("SELECT * FROM student WHERE locationID = {$rows['locationID']} AND studentID = {$row2['studentID']}");
                        while($row = $students->fetch_assoc()):

                            $sql = $conn->query("SELECT * FROM route WHERE routeID = '{$rows['routeID']}'");
                            $route = $sql->fetch_assoc();
                    ?>
                        <tr>
                            <td><?=$route['name']?></td>
                            <td><?=$rows['locationName']?></td>
                            <td><?=$row['firstname'].' '.$row['lastname']?></td>
                            <td><?=$rows['time']?></td>
                            <td><?=$rows['time2']?></td>
                            <td><?=number_format($route['fair'], 2, '.', ',')?></td>
                        </tr>
                    <?php endwhile; endwhile; endwhile ?>
                    </tbody>
                </table>
            </div>
       </div>
        
    </main>
</body>
</html>