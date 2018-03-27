<?php

require_once "../templateEngine/TemplateEngine.php";

$templateEngine = new TemplateEngine();
$templateEngine->setConfigurationFilePath("config.json");
$templateEngine->setParameters([
    "ordinaryVariable" => "Here is ordinary variable",
    "file1" => "/home/eugene/symfony4.conf",
    "img1" => "jquery.png",
    "img2" => "Elephant.png",
    "configKey" => "symfony.id",
    "dataId" => "2",
]);

$templateEngine->showContent("../templates/demoTop.tpl");
