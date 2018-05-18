<?php
    require_once "models/DynamicFormModel/DynamicFormModel.php";
    require_once "templateEngine/TemplateEngine.php";

    $templateEngine = new TemplateEngine();

    $style = getSelectedStyle($_POST["style"]);
    $dataArray = getArrayFromDatabase();
    $templateEngine->setParameters([
        "checked$style" => "checked",
        "style"    => $style,
        "header"   => $dataArray[0]["title"],
        "article1" => $dataArray[1]["text"],
        "article2" => $dataArray[2]["text"],
        "image1"   => $dataArray[3]["image"],
        "image2"   => $dataArray[4]["image"],
    ]);

    $templateEngine->showContent("templates//DynamicForm/top.tpl");
    $templateEngine->showContent("templates//DynamicForm/styleChangingBlock.tpl");
    $templateEngine->showContent("templates//DynamicForm/headerBlock.tpl");
    $templateEngine->showContent("templates//DynamicForm/textBlock.tpl");
    $templateEngine->showContent("templates//DynamicForm/formBlock.tpl");
    $templateEngine->showContent("templates//DynamicForm/imagesBlock.tpl");
    $templateEngine->showContent("templates//DynamicForm/bottom.tpl");
