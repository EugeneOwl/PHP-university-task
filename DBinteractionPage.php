<?php
    require_once "templateEngine/TemplateEngine.php";
    require_once "DBinteraction/DBinteractionFunctions.php";
    require_once "logging/logFunctions.php";

    redirectLogs("/home/eugene/PhpstormProjects/PHP-university-task/logging/my_Logs.log", false);

    $page = basename(__FILE__);
    error_log("Page '$page' was loaded.");

    $imagesPrePath = "images/";
    $templateEngine = new TemplateEngine();
    $data = getData();
    if ($data) {
        $templateEngine->setParameters([
            "content" => [
                "title" => "War planes",
                "mainHeader" => "Planes",
                "headers" => [
                    "header1" => $data[HEADERS][0],
                    "header2" => $data[HEADERS][1],
                    "header3" => $data[HEADERS][2],
                ],
                "articles" => [
                    "article1" => $data[ARTICLES][0],
                    "article2" => $data[ARTICLES][1],
                    "article3" => $data[ARTICLES][2],
                ],
                "images" => [
                    "image1" => $imagesPrePath . $data[IMAGE_PATHS][0],
                    "image2" => $imagesPrePath . $data[IMAGE_PATHS][1],
                    "image3" => $imagesPrePath . $data[IMAGE_PATHS][2],
                ],
            ]
        ]);
    }
    if (getBannerPath()) {
        $templateEngine->setParameters([
            "banner" => $imagesPrePath . getBannerPath(),
        ]);
    }
    $templateEngine->showContent("templates/DBinteraction.tpl");