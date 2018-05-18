<?php

require_once "templateEngine/TemplateEngine.php";
require_once "models/statistics/Subscriber.php";

$templateEngine = new TemplateEngine();
$subscriber = new Subscriber();

if (isset($_POST["subscribeSubmit"])) {
    echo $subscriber->subscribe($_POST["email"]) ? "<script>alert('Successfully subscribed.');</script>" : "<script>alert('Error.');</script>";
}

$templateEngine->setParameters([

]);
$templateEngine->showContent("templates/subscribe.tpl");