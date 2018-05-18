<?php
session_start();

setcookie("Polly", 1, time() + 5);

if (isset($_COOKIE["Polly"])) {
    $_SESSION["visited_pages"]["page_2"] = 1;
}

$page1 = isset($_SESSION["visited_pages"]["page_1"]) ? "Page 1 was visited recently." : "";
$page2 = isset($_SESSION["visited_pages"]["page_2"]) ? "Page 2 was visited recently." : "";
$page3 = isset($_SESSION["visited_pages"]["page_3"]) ? "Page 3 was visited recently." : "";


echo <<< HTML
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page 2</title>
</head>
<body>
    <h1>Page 2</h1>
    <p>{$_COOKIE["name"]}</p>

    <p>$page1</p>
    <p>$page2</p>
    <p>$page3</p>

    <div>
        <div>
            <a href="session_demo_1.php">Page 1</a>
        </div>
        <div>
            <a href="session_demo_2.php">Page 2</a>
        </div>
        <div>
            <a href="session_demo_3.php">Page 3</a>
        </div>
    </div>
</body>
</html>
HTML;
