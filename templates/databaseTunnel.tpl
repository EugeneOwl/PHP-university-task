<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/databaseTunnel.css">
    <title>Tunnel</title>
</head>
<body>
    <div id="wrapper">
        <h1 align="center">Работа с базой данных через клиент</h1>
        <form method="post">
            <div class="window name">
                <label for="languageName">Name</label>
                <input type="text" name="languageName" id="languageName">
            </div>

            <div class="window framework">
                <label for="languageFramework">Framework</label>
                <input type="text" name="languageFramework" id="languageFramework">
            </div>

            <div class="window mark">
                <label for="languageMark">Mark</label>
                <input type="text" name="languageMark" id="languageMark" maxlength="2">
            </div>

            <input type="submit" value="Send query">
        </form>

        <div class="timeSegment">
            <span>Query time: </span> {timeSegment}
        </div>
        <div class="RAM">
            <span>RAM: </span>{RAM}
        </div>
        <div class="reply">
            {reply}
        </div>
    </div>
</body>
</html>