<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar Page</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>
    <div id="wrapper">
        <div id="panel">
            <form action='' method='post'>
                <label for="year">YEAR</label>
                <input type='text' id='year' name="year">
            </form>
        </div>
        {calendarString}
    </div>
</body>
</html>
