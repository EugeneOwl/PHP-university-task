<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin statistics</title>
    <link rel="stylesheet" href="css/adminStatistics.css">
</head>
<body>
    <h1>Statistics managment page</h1>
    <div id="menu">
        <div><a href="statistics_demo_1.php">Statistics demo page 1</a></div>
        <div><a href="statistics_demo_2.php">Statistics demo page 2</a></div>

        <div><a href="subscribe.php">Subscribe page</a></div>
    </div>

    <div>
        <form method="POST">
            <textarea name="message" id="messageArea" cols="20" rows="10" placeholder="message"></textarea>
            <input type="submit" value="Execute dispatch" name="dispatchButton">
        </form>
    </div>
</body>
</html>