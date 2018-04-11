<?php

    define("NOTHING", "Nothing found.");

    function getPDOConnection(): ?PDO
    {
        try {
            $pdo = new PDO("mysql:host=localhost;charset=utf8", "root", "ubuntu6031");
        } catch (Exception $exception) {
            return null;
        }
        return $pdo;
    }

    function getPagesString(array $pagesArr): string
    {
        $URLs = [];
        foreach ($pagesArr as $page) {
            $URLs[] = $page["page"];
        }
        $URLs = array_unique($URLs);
        $pagesString = "";
        foreach ($URLs as $url) {
            $pagesString .= "<a href='$url'>$url</a><br/>";
        }
        return $pagesString;
    }

    function getPages(PDO $pdo, string $pattern): string
    {
        if (empty($pattern)) {
            return NOTHING;
        }
        error_log("Pattern was searched: '$pattern'" .
        " on page " . basename($_SERVER["REQUEST_URI"]));
        $sql = "SELECT page FROM WT5.articles 
                WHERE articles.text LIKE ? OR 
                articles.name LIKE ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(["%$pattern%", "%$pattern%"]);
        $results = $statement->fetchAll();
        return empty($results) ? NOTHING : getPagesString($results);
    }

    function searchPages(string $inputName): string
    {
        if ($pdo = getPDOConnection()) {
            return isset($_POST[$inputName]) ? getPages($pdo, $_POST[$inputName]) : "";
        } else {
            return "";
        }
    }