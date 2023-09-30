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

       <div class="card uxpand"  style="height: 500px; overflow-y:auto">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Parents</li>
                </ol>
            </nav>
            <p class="flex"><b>Parents</b><i class="bx bx-user icon"></i></p>
            <div class="table">

                <table>
                
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Location</th>
                            <th>Child Name</th>
                            <th>Phone Number</th>
                            <th>Phone Number II</th>
                        </tr>
                        <?php 
                           
                            $bus = $conn->query("SELECT * FROM schoolbus WHERE driverID = {$row['userID']}");
                            $busrow = $bus->fetch_assoc();
                            $location = $conn->query("SELECT * FROM stop WHERE routeID = '{$busrow['routeID']}'");
                            while($rowLoc = $location->fetch_assoc()):
                                $pay = $conn->query("SELECT DISTINCT studentID FROM payment WHERE month(date) = month(now()) AND year(date) = year(now())");
                                while($row2 = $pay->fetch_assoc()):
                                    $students = $conn->query("SELECT * FROM student WHERE studentID = {$row2['studentID']} AND locationID = {$rowLoc['locationID']}");
                                    while($rowStudent = $students->fetch_assoc()):
                    ?>
                                        <tr>
                                            <td><?=$rowStudent['parentName']?></td>
                                            <td><?=$rowLoc['locationName']?></td>
                                            <td><?=$rowStudent['firstname']. ' '.$rowStudent['lastname']?></td>
                                            <td><?=$rowStudent['phone']?></td>
                                            <td><?=$rowStudent['phone2']?></td>
                                        </tr>
                    <?php
                                    endwhile;
                                endwhile;
                            endwhile;
                            
                        ?>
                    </thead>
                    <tbody>
                    
                    
                    </tbody>
                </table>
            </div>
       </div>
        
    </main>
</body>
</html>