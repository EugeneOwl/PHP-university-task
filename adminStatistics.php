<?php

require_once "templateEngine/TemplateEngine.php";
require_once "models/statistics/AdminDistributor.php";

$templateEngine = new TemplateEngine();
$distributor = new AdminDistributor();

if (isset($_POST["dispatchButton"])) {
    $distributor->distributeMessage($_POST["message"]);
}

$templateEngine->setParameters([

]);
$templateEngine->showContent("templates/adminStatistics.tpl");
