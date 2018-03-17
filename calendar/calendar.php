<?php

require_once "calendarFunctions.php";

$months = [
    'January', 'February', 'March',
    'April', 'May', 'June',
    'July', 'August', 'September',
    'October', 'November', 'December'
];
$dayInMonths = [
    31, 28, 31,
    30, 31, 30,
    31, 31, 30,
    31, 30, 31
];
$celebrations = [
    0 => ["day" => 1, "title" => "New_year"],
    1 => ["day" => 23, "title" => "Protector_day"],
    2 => ["day" => 8, "title" => "Woman_day"],
    3 => ["day" => 1, "title" => "Fool_day"],
    8 => ["day" => 1, "title" => "Knowledge_day"],
];
if (($_POST['year']) % 4 == 0) {
    $dayInMonths[1]++;
}
$dayOfWeek = date("w", strtotime($_POST['year']."-01-01"));

$calendarString = drawCalendar($months, $dayOfWeek, $dayInMonths, $celebrations);

