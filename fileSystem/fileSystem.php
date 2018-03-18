<?php

require_once "../templateEngine/TemplateEngine.php";
require_once "fileSystemFunctions.php";

$path = "/home/eugene/PhpstormProjects/PHP-university-task/fileSystem/sandbox/";
$templateEngine = new TemplateEngine();

$templateEngine->setParameter([
    "panel" => createPanel($path),
    "content" => getContentsArray($path),
]);

$templateEngine->showContent("../templates/fileSystem.tpl");