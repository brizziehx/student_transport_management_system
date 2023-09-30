<?php 

    session_start();
    require('../db/db.php');

    $now = $_GET['month'];
    $year = $_GET['year'];

    $timestamp = mktime(0, 0, 0, $now, 28, $year);

    $date = date('F Y', $timestamp);

    $studentID = $_REQUEST['id'];

    if(!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }

    include('greet.php');

    $admin = $conn->query("SELECT * FROM users WHERE userID = {$_SESSION['unique_id']}");
    $row_ = $admin->fetch_assoc();

    $users = $conn->query("SELECT * FROM users WHERE NOT usertype = '{$row_['usertype']}'");


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
        .hidden {
            visibility: hidden;
        }
        h4:last-child {
            border-bottom: none;
        }
    </style>
       
</head>
<body>
    <div class="container">
        <div class="print">

        
            <header>
                <h1>school transport management system</h1>
                <h3>Payment Report</h3>
            </header>
            <main>
               
                <p><span class="bold">Name of Student: </span><?=$row2['firstname']. ' '.$row2['lastname']?>.</p>
                <p><span class="bold">Month: </span><?=$date?>.</p>
                <p><span class="bold">No. of Installments: </span><?=$pay->num_rows?>.</p>
                <p><span class="bold">Route: </span><?=$row4['name']?>.</p>
                <p><span class="bold">Location: </span><?=$row3['locationName']?>.</p>
                <p><span class="bold">Cost: </span><?=number_format($row4['fair'], 2, '.', ',') ?> /- Tsh.</p>
                
                <div class="paid">
                    <h3>Payment Details</h3>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Date </th>
                            <th>Parent | Sponsor</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                            $count = 0;
                            $data = $conn->query("SELECT * FROM payment WHERE studentID = {$studentID} AND (month(date) = $now AND year(date) = $year)");
                            while($row = $data->fetch_assoc()):
                                $count++;

                                $dt = explode('-', $row['date']);
                                $yr = $dt[0];
                                $month = $dt[1];
                                $day = $dt[2];

                                $timestmp = mktime(0, 0, 0, $month, $day, $yr);
                        ?>
                        <tr>
                            <td><?=$count?></td>
                            <td><?=date('jS F Y', $timestmp) ?></td>
                            <td><?=$row2['parentName']?></td>
                            <td><?=number_format($row['amount'], 2, '.', ',')?></td>
                        </tr>
                        <?php endwhile ?>
                    </table>
                    <h4>Total Paid: <span><?=number_format($paye, 2, '.', ',') ?> /- Tsh</span></h4>
                    <h4>Outstanding Amount: <span><?=number_format($balance, 2, '.', ',') ?> /- Tsh</span></h4>
                    
                    <div class="hidden">
                        <h4>Printed By: <?=$row_['usertype']?><span><?php echo $row_['firstname'].' '.$row_['lastname'];?></span></h4>
                    </div>
                </div>

            </main>
        </div>
            <div class="buttons">
                <a href="details.php?id=<?=$_GET['id']?>"><i class="bx bx-undo"></i>Go Back</a>
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