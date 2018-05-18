<?php

    define("MISTAKE_FOR_USER", "Server-side mistake.");

    function getArrayFromDatabase(): array
    {
        try {
            $pdo = new PDO(
                "mysql:host=127.0.0.1;encoding=utf8;dbname=dynamicForms",
                "root",
                "ubuntu6031"
            );
        } catch (Exception $exception) {
            return["error" => MISTAKE_FOR_USER];
        }
        $statement = $pdo->prepare("SELECT * FROM `contents` LIMIT 200");
        $statement->execute();
        if ($statement) {
            $arr = $statement->fetchAll();
        } else {
            return ["error" => MISTAKE_FOR_USER];
        }
        return $arr;
    }

    function getSelectedStyle(?string $post)
    {
        if (isset($post)) {
            return intval($post);
        }
        return 0;
    }
