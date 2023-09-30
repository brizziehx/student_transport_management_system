<?php

date_default_timezone_set('Africa/Nairobi');

$time = date('H');

switch($time) {

    case ($time >= 12 && $time <= 15);
        $greetings = "Good Afternoon, ";
    break;
    case $time >= 16 && $time <= 21;
        $greetings = "Good Evening, ";
    break;
    case $time >= 22 && $time <= 23;
        $greetings = "Good Night, ";
    break;
    case $time >= 00 && $time <= 02;
        $greetings = "Good Night, ";
    break;
    case ($time >= 3 && $time <= 11);
        $greetings = "Good Morning, ";
    break;
    default;
        $greetings = "Good Day, ";

}

?>