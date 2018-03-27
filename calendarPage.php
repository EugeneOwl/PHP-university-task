<?php

require_once "templateEngine/TemplateEngine.php";
require_once "calendar/calendar.php";

$templateEngine = new TemplateEngine();
$templateEngine->setParameters([
    "calendarString" => $calendarString,
]);
$templateEngine->showContent("templates/calendar.tpl");
