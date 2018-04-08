<?php

    define("HEADERS", "headers");
    define("ARTICLES", "articles");
    define("IMAGE_PATHS", "images");
    define("BANNER_PATH", "banner");

    function getPDOConnection(): ?PDO
    {
        try {
            $pdo = new PDO("mysql:host=localhost", "root", "ubuntu6031");
        } catch (Exception $exception) {
            return null;
        }
        return $pdo;
    }

    function getDataArray(PDO $pdo): array
    {
        $sql = "SELECT name, text, imagePath FROM WT5.articles";
        $statement = $pdo->query($sql);
        return $statement ? $statement->fetchAll() : [];
    }

    function getData(): array
    {
        if ($pdo = getPDOConnection()) {
            $data = [];
            foreach (getDataArray($pdo) as $row) {
                $data[HEADERS][] = $row["name"];
                $data[ARTICLES][] = $row["text"];
                $data[IMAGE_PATHS][] = $row["imagePath"];
            }
            return $data;
        } else {
            return [];
        }
    }

    function getBannersArray(PDO $pdo): array
    {
        $sql = "SELECT imagePath FROM WT5.banners";
        $statement = $pdo->query($sql);
        return $statement ? $statement->fetchAll(): [];
    }

    function getBannerPath(): string
    {
        if ($pdo = getPDOConnection()) {
            $bannersArray = getBannersArray($pdo);
            return $bannersArray ? $bannersArray[mt_rand(0, count($bannersArray) - 1)]["imagePath"] : "";
        } else {
            return "";
        }
    }
