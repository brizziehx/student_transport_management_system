<?php


    $dateTime2 = explode(' ', $row['updated']);
        
    $date2 = explode('-', $dateTime2[0]);
    $time2 = explode(':', $dateTime2[1]);

    $year2 = $date2[0];
    $month2 = $date2[1];
    $day2 = $date2[2];
    $hour2 = $time2[0];
    $min2 = $time2[1];
    $sec2 = $time2[2];

    $timestamp2 = mktime($hour2, $min2, $sec2, $month2, $day2, $year2);
    // echo date('jS F Y', $timestamp2);

?>