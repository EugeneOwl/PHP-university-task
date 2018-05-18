<?php

require_once "templateEngine/TemplateEngine.php";
require_once "models/statistics/Visitors_counter.php";
require_once "models/statistics/ReportSender.php";

$templateEngine = new TemplateEngine();
$visitorsCounter = new Visitors_counter(basename(__FILE__));

$reportSender = new ReportSender(basename(__FILE__));

if (isset($_POST["reportButton"])) {
    $reportSender->sendReport();
}

$visitorsCounter->updateStatistics();

$templateEngine->setParameters([
    "visits_amount" => $visitorsCounter->getVisitsAmount(),
]);
$templateEngine->showContent("templates/STATISTICS/statistics_template_2.tpl");