<?php

require_once "regexFunctions.php";

$rawText = getRawText();
$processedText = getProcessedText($rawText);

$rawTextReport = getStringReport($rawText);
$processedTextReport = getStringReport(excludeWhitespaces($rawText));