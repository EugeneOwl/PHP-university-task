<?php

    require_once "templateEngine/TemplateEngine.php";
    require_once "databaseTunnel/databaseTunnelFunctions.php";
    require_once "logging/logFunctions.php";

    redirectLogs("/home/eugene/PhpstormProjects/PHP-university-task/logging/my_Logs.log", false);

    $page = basename(__FILE__);
    error_log("Page '$page' was loaded.");

    $templateEngine = new TemplateEngine();
    $replyStat = getReplyStat();

    $templateEngine->setParameters([
        "reply" => $replyStat["reply"],
        "timeSegment" => $replyStat["timeSegment"],
        "RAM" => $replyStat["RAM"],
    ]);
    $templateEngine->showContent("templates/databaseTunnel.tpl");
