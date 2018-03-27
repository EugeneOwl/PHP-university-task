<?php

require_once "templateEngine/TemplateEngine.php";

$templateEngine = new TemplateEngine();

$templateEngine->setParameters([
    "title" => "Авто",
    "header" => "Автомобили",
    "measure" => "мм",
    "car1" => "ГАЗ-ММ",
    "car2" => "ЗИС-42",
    "car3" => "ЗИС-6",
]);

$templateEngine->showContent("templates/auto.tpl");