<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

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
                <form action="" method="POST" autocomplete="off">
                    <li class="search-box">
                        <i class="bx bx-search icon"></i>
                        <input type="text"  name="searchTerm" placeholder="search...">
                    </li>
                </form>
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

            if(isset($_POST['searchTerm'])):
                $name = $_POST['searchTerm'];
                $name = addslashes($name);
                $name = trim($name);

                $select = $conn->query("SELECT * FROM route WHERE name LIKE '%{$name}%' OR routeID LIKE '%{$name}%'");
                if($select->num_rows > 0): ?>
                    <div class="cards grid">

                        <div href="#" class="card xxxpand">
                            <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Routes</li>
                                </ol>
                            </nav>
                            <p class="flex"><b>All Routes</b><a href="addroute.php"><i class="bx bx-trip icon"></i></a></p>
                            <?=$_SESSION['msg'] ?? '' ?>
                            <?php unset($_SESSION['msg']) ?>
                            <div class="table">

                            <table>
                                <thead>
                                    <tr>
                                        <th>Route ID</th>
                                        <th>Route Name</th>
                                        <th>Start</th>
                                        <th>Finish</th>
                                        <th>Fair</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
        <?php       while($row = $select->fetch_assoc()): 
                        $fair = number_format($row['fair'], 2, '.', ',');
                        $routeName = $row['name']; 
        ?>

                        <tr>

                                <td><?=$row['routeID']?></td>
                                <td><a href="stops.php?routeID=<?=$row['routeID']?>"><?=$routeName?></a></td>
                                <td><?=$row['start']?></td>
                                <td><?=$row['finish']?></td>
                                <td><?=$fair?></td>
                                <td>
                                    <a class=btn-edit onclick="if(confirm('Are you sure you want to edit this route?') === false) { event.preventDefault() }" href=editroute.php?routeID=<?=$row['routeID']?>><i class="bx bx-edit icon"></i></a>
                                    <a class=btn-delete onclick="if(confirm('Are you sure you want to delete this route?') === false) { event.preventDefault() }" href=deleteroute.php?routeID=<?=$row['routeID']?>><i class="bx bx-trash icon"></i></a>
                                </td>
                            </tr>
                        </tr>
        
            <?php    endwhile; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        <?php   else: ?>
                <div class="cards grid">
                    <div href="#" class="card xxxpand">
                        <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                                <li class="breadcrumb-item active" aria-current="page">No Route</li>
                            </ol>
                        </nav>
                        <p class="flex"><b>No Route</b><a href="addroute.php"><i class="bx bx-trip icon"></i></a></p>

                        <p style="grid-column: span 12; margin-left: 20px">Sorry! That Route doesn't exist</p>
                    </div>
                </div>
        <?php
                endif; 
            else:
        ?>

        <div class="cards grid">

            <div href="#" class="card xxxpand">
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Routes</li>
                    </ol>
                </nav>
                <p class="flex"><b>All Routes</b><a href="addroute.php"><i class="bx bx-trip icon"></i></a></p>

                <?=$_SESSION['msg'] ?? '' ?>
                <?php unset($_SESSION['msg']) ?>
                <?php unset($_SESSION['name']) ?>

                <div class="table">

                <table>
                    <thead>
                        <tr>
                            <th>Route ID</th>
                            <th>Route Name</th>
                            <th>Start</th>
                            <th>Finish</th>
                            <th>Fair</th>
                            <th>Actions</th>
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
                                <td><?=$fair?></td>
                                <td>
                                    <a class=btn-edit onclick="if(confirm('Are you sure you want to edit this route?') === false) { event.preventDefault() }" href=editroute.php?routeID=<?=$row['routeID']?>><i class="bx bx-edit icon"></i></a>
                                    <a class=btn-delete onclick="if(confirm('Are you sure you want to delete this route?') === false) { event.preventDefault() }" href=deleteroute.php?routeID=<?=$row['routeID']?>><i class="bx bx-trash icon"></i></a>
                                </td>
                            </tr>
                         <?php   }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        
        </div>
        </div>
    <?php endif ?>
        
        <footer>
            <p>School Transport Management System &copy; 2023. All Rights Reserved</p>
        </footer>
    </main>
    <script src="../js/script.js"></script>
</body>
</html>