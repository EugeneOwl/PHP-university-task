<?php

require_once "templateEngine/TemplateEngine.php";
require_once "databaseTunnel/databaseTunnelFunctions.php";

$templateEngine = new TemplateEngine();
$replyStat = getReplyStat();

$templateEngine->setParameters([
    "reply" => $replyStat["reply"],
    "timeSegment" => $replyStat["timeSegment"],
    "RAM" => $replyStat["RAM"],
]);
$templateEngine->showContent("templates/databaseTunnel.tpl");
