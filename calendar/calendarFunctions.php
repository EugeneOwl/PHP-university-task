<?php

function drawCalendar(array $months, int $dayOfWeek, array $dayInMonths, array $celebrations): string
{
    $calendarString = "<table border='1'>";
    for ($monthNumber = 0; $monthNumber < 12; $monthNumber++) {
        $calendarString .= "<tr><th colspan='7'>$months[$monthNumber]</th></tr>";

        $newData = showFirstWeek($dayOfWeek, $celebrations, $monthNumber);
        $dayOfWeek = $newData[0];
        $currentDay = $newData[1];
        $calendarString .= $newData["calendarString"];

        $newData = showOtherWeeks($dayOfWeek, $currentDay, $dayInMonths, $monthNumber, $celebrations);
        $dayOfWeek = $newData[0];
        $calendarString .= $newData["calendarString"];
    }
    $calendarString .= "</table>";
    return $calendarString;
}

function showFirstWeek(int $dayOfWeek, array $celebrations, int $monthNumber): array
{
    $calendarString = "<tr>";
    $currentDay = 1;
    if ($dayOfWeek == 0) {
        $dayOfWeek = 7;
    }
    for ($iterator = $dayOfWeek; $iterator < 8; $iterator++) {
        $calendarString .= getCellDay($celebrations, $monthNumber, $currentDay);
        $currentDay++;
        $dayOfWeek = ($dayOfWeek + 1) % 7;
    }
    $calendarString .= "</tr>";
    return [$dayOfWeek, $currentDay, "calendarString" => $calendarString];
}

function showOtherWeeks(int $dayOfWeek, int $currentDay, array $dayInMonths, int $monthNumber, array $celebrations): array
{
    $calendarString = "<tr>";
    for (;;) {
        for ($iterator = 0; $iterator < 7; $iterator++) {
            $calendarString .= getCellDay($celebrations, $monthNumber, $currentDay);
            $currentDay++;
            $dayOfWeek = ($dayOfWeek % 7) + 1;
            if ($currentDay > $dayInMonths[$monthNumber]) {
                break;
            }
        }
        if ($currentDay > $dayInMonths[$monthNumber]) {
            break;
        }
        $calendarString .= "</tr>";
    }
    return [$dayOfWeek, "calendarString" => $calendarString];
}

function getCellDay(array $celebrations, int $monthNumber, int $currentDay): string
{
    $calendarString = "";
    if (isset($celebrations[$monthNumber]) && $celebrations[$monthNumber]["day"] == $currentDay) {
        $calendarString .= "<td class='celebration' title=" . $celebrations[$monthNumber]["title"] . ">$currentDay</td>";
    } else {
        $calendarString .= "<td>$currentDay</td>";
    }
    return $calendarString;
}