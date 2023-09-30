<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }
    
    $total_records_per_page = 25;
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2"; 

    $result_count = $conn->query("SELECT COUNT(*) As total_records FROM student");
    $total_records = $result_count->fetch_array();
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total page minus 1

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
 
    <title>Dashboard - <?php echo date('Y') ?> Report</title>
    <style>
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
        }
        .btn i {
            margin-right: 5px;
        }

    </style>
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
                        <input type="text" value="<?=$_SESSION['nm'] ?? ''?>" name="searchTerm" placeholder="search...">
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

            <div href="#" class="card xxxpand" >
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="students.php">All Students</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo date('Y') ?> Report</li>
                    </ol>
                </nav>
                <p class="flex"><b>2023 Report</b><i class="bx bx-calendar icon"></i></p>
                <?=$_SESSION['msg'] ?? '' ?>
                <?php unset($_SESSION['msg']) ?>
                <div class="table">

                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fullname</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th style="color:#f00">June</th>
                            <th>July</th>
                            <th>Aug</th>
                            <th>Sept</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th style="color:#f00">Dec</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $now = date('m');
                            $year = date('Y');

                            $result = $conn->query("SELECT * FROM student LIMIT $offset, $total_records_per_page");
                            while($row2 = $result->fetch_assoc()):

                                $loc = $conn->query("SELECT * FROM stop WHERE locationID = {$row2['locationID']}");
                                $row3 =$loc->fetch_assoc();

                                $route = $conn->query("SELECT * FROM route WHERE routeID = '{$row3['routeID']}'");
                                $row4 = $route->fetch_assoc();

                                $paye = 0;
                                $paye2 = 0;
                                $paye3 = 0;
                                $paye4 = 0;
                                $paye5 = 0;
                                $paye6 = 0;
                                $paye7 = 0;
                                $paye8 = 0;
                                $paye9 = 0;
                                $paye10 = 0;
                                $paye11 = 0;
                        
                                include('paye.php')

                        ?>
                        
                        <tr>
                            <td><?=$row2['studentID']?></td>
                            <td><a href="details.php?id=<?=$row2['studentID']?>"><?=$row2['firstname'].' '.$row2['lastname']?></a></td>
                            <td><?=$status?></td>
                            <td><?=$status2?></td>
                            <td><?=$status3?></td>
                            <td><?=$status4?></td>
                            <td><?=$status5?></td>
                            <td>Leave</td>
                            <td><?=$status7?></td>
                            <td><?=$status8?></td>
                            <td><?=$status9?></td>
                            <td><?=$status10?></td>
                            <td><?=$status11?></td>
                            <td>Leave</td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
                
            </div>

            <div class="button">
                <a class="btn" href="allprint.php"><i class="bx bx-detail"></i>Print Report</a>
            </div>

        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
            <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>

            <ul class="pagination">
                <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
                
                <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
                <a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
                </li>
                
                <?php 
                    if ($total_no_of_pages <= 10){  	 
                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                            if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";	
                                }else{
                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                }
                        }
                    }
                    elseif($total_no_of_pages > 10){
                    
                    if($page_no <= 4) {			
                        for ($counter = 1; $counter < 8; $counter++){		 
                                if ($counter == $page_no) {
                                        echo "<li class='active'><a>$counter</a></li>";	
                                    }else{
                                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                    }
                        }
                                echo "<li><a>...</a></li>";
                                echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                                echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    }

                    elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
                        echo "<li><a href='?page_no=1'>1</a></li>";
                        echo "<li><a href='?page_no=2'>2</a></li>";
                        echo "<li><a>...</a></li>";
                        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                        if ($counter == $page_no) {
                                echo "<li class='active'><a>$counter</a></li>";	
                            }else{
                                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                            }                  
                        }
                            echo "<li><a>...</a></li>";
                            echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                            echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
                    }
                        
                    else {
                        echo "<li><a href='?page_no=1'>1</a></li>";
                        echo "<li><a href='?page_no=2'>2</a></li>";
                        echo "<li><a>...</a></li>";

                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                    if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";	
                    }else{
                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                    }                   
                }
                    }
                }
            ?>
                
                <li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
                <a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
                </li>
                <?php if($page_no < $total_no_of_pages){
                    echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                    } ?>
            </ul>
        </div>
        </div>
        
        <footer>
            <p>School Transport Management System &copy; 2023. All Rights Reserved</p>
        </footer>
    </main>
    <script src="../js/script.js"></script>
</body>
</html>