<?php
    $wordNumber = 1;
    $words = [];
    for ($number = 0; $number < strlen($data); $number++) {
        $words[$wordNumber] .= $data[$number];
        if ($data[$number] == ' ') {
            $wordNumber++;
        }
    }

    $newData = "";

    for($number = 0; $number < count($words); $number++) {
        if ($number % 3 == 0) {
            $words[$number] = mb_strtoupper($words[$number]);
            $newData .= $words[$number] . ' ';
        } else {
            $newData .= $words[$number] . ' ';
        }
    }
    echo "<br>";

    $number = 0;
    $letterNumber = 1;
    $string = "";
    $difference = 5;
    while ($number < strlen($newData)-1) {
        if (($letterNumber - 5) % 6 == 0) {
            $string .= '<span style="color: purple;">';
            $string .= $newData[$letterNumber] . $newData[$letterNumber + 1];
            $string .= "</span>";
        } else {
            $string .= $newData[$letterNumber] . $newData[$letterNumber + 1];
        }
        $letterNumber += 2;
        $number++;
    }
    echo '<p>'.$string.'</p>';

    echo '<br>';
    echo "<p>Колличество \"о\" = " . substr_count($newData, 'о') . "<br>";
    echo "Колличество \"О\" = " . substr_count($newData, 'О') . "</p><br>";
