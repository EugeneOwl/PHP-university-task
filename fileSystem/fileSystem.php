<?php

require_once "../templateEngine/TemplateEngine.php";
require_once "fileSystemFunctions.php";

$templateEngine = new TemplateEngine();

$templateEngine->setParameter([
    "panel" => createPanel("/home/eugene/PhpstormProjects/WT-3/fileSystem/sandbox/"),
]);

$templateEngine->showContent("../templates/fileSystem.tpl");