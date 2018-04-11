<?php
    require_once "templateEngine/TemplateEngine.php";
    require_once "search/searchFunctions.php";
    require_once "logging/logFunctions.php";

    redirectLogs("/home/eugene/PhpstormProjects/PHP-university-task/logging/my_Logs.log", false);

    $page = basename(__FILE__);
    error_log("Page '$page' was loaded.");

    $templateEngine = new TemplateEngine();
    $templateEngine->setParameters([
       "searchResults" => searchPages("search"),
    ]);
    $templateEngine->showContent("templates/index.tpl");
