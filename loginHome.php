<?php
    require_once "templateEngine/TemplateEngine.php";
    require_once "models/login/HomeService.php";

    $templateEngine = new TemplateEngine();
    $homeService = new HomeService();

    $homeService->executeDeletion($_COOKIE["admin"], $_POST["delete"]);
    $templateEngine->setParameters([
        "userList" => $homeService->getUserListTable($_COOKIE["admin"]),
    ]);
    $templateEngine->showContent("templates/LOGIN/homePage.tpl");
