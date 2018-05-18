<?php
    require_once "templateEngine/TemplateEngine.php";
    require_once "models/login/LoginService.php";
    require_once "models/login/RegistrationService.php";

    $templateEngine = new TemplateEngine();
    $loginService = new LoginService();
    $logupService = new RegistrationService();

    $loginResult = $loginService->verifyLogin(
        $_POST["login_submit"],
        $_POST["login_username"],
        $_POST["login_password"]
    );
    $logupResult = $logupService->verifyLogup(
        $_POST["logup_submit"],
        $_POST["logup_username"],
        $_POST["logup_password"],
        $_POST["logup_password_second"]
    );

    $templateEngine->setParameters([
        "login_username_error" => $loginResult["loginError"],
        "login_password_error" => $loginResult["passwordError"],
        "logup_username_error" => $logupResult["loginError"],
        "logup_password_error" => $logupResult["passwordError"],
    ]);
    $templateEngine->showContent("templates/LOGIN/index.tpl");
    $templateEngine->showContent("templates/LOGIN/login_form.tpl");
    $templateEngine->showContent("templates/LOGIN/logup_form.tpl");
    $templateEngine->showContent("templates/LOGIN/bottom.tpl");

    if ($loginResult["isValid"] || $logupResult["isValid"]) {
        header("Location: loginHome.php");
    }