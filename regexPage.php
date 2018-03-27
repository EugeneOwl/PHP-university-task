<?php

require_once "templateEngine/TemplateEngine.php";
require_once "regex/regex.php";

$templateEngine = new TemplateEngine();
$templateEngine->setParameters([
    "rawText" => $rawText,
    "rawTextLength" => $rawTextReport,
    "processedText" => $processedText,
    "processedTextLength" => $processedTextReport,
]);
$templateEngine->showContent("templates/regex.tpl");
