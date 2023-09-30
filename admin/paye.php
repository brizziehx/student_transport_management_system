<?php

    // JANUARY
    $pay = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 1 AND year(date) = $year)");
    while($row = $pay->fetch_assoc()) {
        
        $paye = $paye + $row['amount'];

    }


    if($paye > 0 && $paye < $row4['fair']) {
        $status = "<span class='status3'>Incomplete</span>";
    } elseif($paye > 0 && $paye >= $row4['fair']) {
        $status = "<span class='status'>Complete</span>";
    }
    else {
        $status = "<span class='status2'>Not paid</span>";
    }


    // FEBRUARY
    $pay2 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 2 AND year(date) = $year)");
    while($row = $pay2->fetch_assoc()) {
        
        $paye2 = $paye2 + $row['amount'];

    }



    if($paye2 > 0 && $paye2 < $row4['fair']) {
        $status2 = "<span class='status3'>Incomplete</span>";
    } elseif($paye2 > 0 && $paye2 >= $row4['fair']) {
        $status2 = "<span class='status'>Complete</span>";
    }
    else {
        $status2 = "<span class='status2'>Not paid</span>";
    }
    

     // MARCH
    $pay3 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 3 AND year(date) = $year)");
    while($row = $pay3->fetch_assoc()) {
        
        $paye3 = $paye3 + $row['amount'];

    }


    if($paye3 > 0 && $paye3 < $row4['fair']) {
        $status3 = "<span class='status3'>Incomplete</span>";
    } elseif($paye3 > 0 && $paye3 >= $row4['fair']) {
        $status3 = "<span class='status'>Complete</span>";
    }
    else {
        $status3 = "<span class='status2'>Not paid</span>";
    }

     // APRIL
     $pay4 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 4 AND year(date) = $year)");
     while($row = $pay4->fetch_assoc()) {
         
         $paye4 = $paye4 + $row['amount'];
 
     }
 
 
     if($paye4 > 0 && $paye4 < $row4['fair']) {
         $status4 = "<span class='status3'>Incomplete</span>";
     } elseif($paye4 > 0 && $paye4 >= $row4['fair']) {
         $status4 = "<span class='status'>Complete</span>";
     }
     else {
         $status4 = "<span class='status2'>Not paid</span>";
     }

      // MAY
    $pay5 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 5 AND year(date) = $year)");
    while($row = $pay5->fetch_assoc()) {
        
        $paye5 = $paye5 + $row['amount'];

    }


    if($paye5 > 0 && $paye5 < $row4['fair']) {
        $status5 = "<span class='status3'>Incomplete</span>";
    } elseif($paye5 > 0 && $paye5 >= $row4['fair']) {
        $status5 = "<span class='status'>Complete</span>";
    }
    else {
        $status5 = "<span class='status2'>Not paid</span>";
    }

    // JULY
    $pay7 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 7 AND year(date) = $year)");
    while($row = $pay7->fetch_assoc()) {
        
        $paye7 = $paye7 + $row['amount'];

    }



    if($paye7 > 0 && $paye7 < $row4['fair']) {
        $status7 = "<span class='status3'>Incomplete</span>";
    } elseif($paye7 > 0 && $paye7 >= $row4['fair']) {
        $status7 = "<span class='status'>Complete</span>";
    }
    else {
        $status7 = "<span class='status2'>Not paid</span>";
    }

    // AUGUST
    $pay8 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 8 AND year(date) = $year)");
    while($row = $pay8->fetch_assoc()) {
        
        $paye8 = $paye8 + $row['amount'];

    }



    if($paye8 > 0 && $paye8 < $row4['fair']) {
        $status8 = "<span class='status3'>Incomplete</span>";
    } elseif($paye8 > 0 && $paye8 >= $row4['fair']) {
        $status8 = "<span class='status'>Complete</span>";
    }
    else {
        $status8 = "<span class='status2'>Not paid</span>";
    }

    // SEPTEMBER
    $pay9 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 9 AND year(date) = $year)");
    while($row = $pay9->fetch_assoc()) {
        
        $paye9 = $paye9 + $row['amount'];

    }


    if($paye9 > 0 && $paye9 < $row4['fair']) {
        $status9 = "<span class='status3'>Incomplete</span>";
    } elseif($paye9 > 0 && $paye9 >= $row4['fair']) {
        $status9 = "<span class='status'>Complete</span>";
    }
    else {
        $status9 = "<span class='status2'>Not paid</span>";
    }

    // OCTOBER
    $pay10 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 10 AND year(date) = $year)");
    while($row = $pay10->fetch_assoc()) {
        
        $paye10 = $paye10 + $row['amount'];

    }


    if($paye10 > 0 && $paye10 < $row4['fair']) {
        $status10 = "<span class='status3'>Incomplete</span>";
    } elseif($paye10 > 0 && $paye10 >= $row4['fair']) {
        $status10 = "<span class='status'>Complete</span>";
    }
    else {
        $status10 = "<span class='status2'>Not paid</span>";
    }

    // NOVEMBER
    $pay11 = $conn->query("SELECT * FROM payment WHERE studentID = {$row2['studentID']} AND (month(date) = 11 AND year(date) = $year)");
    while($row = $pay11->fetch_assoc()) {
        
        $paye11 = $paye11 + $row['amount'];

    }


    if($paye11 > 0 && $paye10 < $row4['fair']) {
        $status11 = "<span class='status3'>Incomplete</span>";
    } elseif($paye11 > 0 && $paye11 >= $row4['fair']) {
        $status11 = "<span class='status'>Complete</span>";
    }
    else {
        $status11 = "<span class='status2'>Not paid</span>";
    }