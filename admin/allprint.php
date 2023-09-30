<?php 

    session_start();
    require('../db/db.php');

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row7 = $admin->fetch_assoc();

    $users = $conn->query("SELECT * FROM users WHERE NOT usertype = '{$row7['usertype']}'");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report | School Transport Management System</title>
    <link rel="stylesheet" href="../print.css">
    <link rel="stylesheet" href="../boxicons/css/boxicons.min.css">
    <style>
        .paid h4 span {
            margin-right: 0px
        }
        .paid h4:last-child {
            border-bottom: none;
        }
        .hidden {
            visibility: hidden;
        }

    </style>
       
</head>
<body>
    <div class="container">
        <div class="print">
            <?php
                // $noRoutes = $conn->query("SELECT * FROM route");
                // $routex = ($noRoutes->num_rows > 1) ? 'Routes' : 'Route';
            ?>
        
            <header>
                <h1>school transport management system</h1>
                <h3>Year <?=date('Y')?> Payment Report</h3>
            </header>
            <main>
               
                <!-- <p><span class="bold">No. Of Available Routes:</span> <?=$noRoutes->num_rows .' '. $routex?>.</p>
                <p><span class="bold">Location: </span><?=$date?>.</p>
                <p><span class="bold">No. of Installments: </span><?=$pay->num_rows?>.</p>
                <p><span class="bold">Route: </span><?=$row4['name']?>.</p>
                <p><span class="bold">Location: </span><?=$row3['locationName']?>.</p>
                <p><span class="bold">Cost: </span><?=number_format($row4['fair'], 2, '.', ',') ?> /= Tsh.</p>
                 -->
                <div class="paid">
                    <h3>Payment Details</h3>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Paid</th>
                            <th>Outstanding</th>
                            <th>Fare</th>
                        </tr>
                        <?php
                            $sumAllroute = 0;
                            $now = date('m');
                            $year = date('Y');
                            $sum = 0;
                            $count = 0;
                            $sumpaid = 0;
                            $result = $conn->query("SELECT * FROM student");
                            while($row2 = $result->fetch_assoc()):

                                $loc = $conn->query("SELECT * FROM stop WHERE locationID = {$row2['locationID']}");
                                $row3 =$loc->fetch_assoc();

                                $route = $conn->query("SELECT * FROM route WHERE routeID = '{$row3['routeID']}'");
                                $row4 = $route->fetch_assoc();

                                $sumroute = $sumpaid + $row4['fair'];

                                

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
                        
                                include('paye.php');

                                $sumpaid = $paye + $paye2 + $paye3 + $paye4 + $paye5 + $paye7 + $paye8 + $paye9 + $paye10 + $paye11;

                                $sum = $sum + $sumpaid;

                                $sumAllroute = $sumAllroute + $row4['fair'];

                                $balance = ($row4['fair'] * 10) - $sumpaid;
                                $count++;
                        ?>
                        
                        <tr>
                            <td><?=$count?></td>
                            <td><?=$row2['firstname']?></td>
                            <td><?=$row2['lastname'] ?></td>
                            <td><?=number_format($sumpaid, 2, '.', ',')?></td>
                            <td><?=number_format($balance, 2, '.',',') ?></td>
                            <td><?=number_format($row4['fair'] * 10, 2, '.', ',')?></td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                    <h4>Total Paid: <span><?=number_format($sum, 2, '.', ',') ?> /- Tsh</span></h4>
                    <h4>Outstanding Amount: <span><?=number_format(($sumAllroute * 10) - $sum, 2, '.', ',') ?> /- Tsh</span></h4>
                    <h4>Total Amount of Fare Based on Students: <span><?=number_format($sumAllroute * 10, 2, '.', ','); ?> /- Tsh</span></h4>
                    
                    <div class="hidden">
                        <h4>Printed By: <?=$row7['usertype']?><span><?php echo $row7['firstname'].' '.$row7['lastname'];?></span></h4>
                    </div>
                    
                  
                </div>

            </main>
        </div>
            <div class="buttons">
                <a href="view.php"><i class="bx bx-undo"></i>Go Back</a>
                <a class="printBtn"><i class="bx bx-printer"></i>Print Report</a>
            </div>
    </div>


    <script>
        const printBtn = document.querySelector('.printBtn');
        printBtn.addEventListener('click', function() {
            print()
        });
    </script>
</body>
</html>