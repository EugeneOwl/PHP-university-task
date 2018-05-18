<?php

require_once "../templateEngine/TemplateEngine.php";

$templateEngine = new TemplateEngine();

function getConnection(): ?PDO
{
    try {
        $connection = new PDO(
            "mysql:host=localhost;dbname=shop",
            "root",
            "************"
        );
        return $connection;
    } catch (Exception $exception) {
        echo "Inner database trouble.";
    }
    return null;
}

function getProductList(): array
{
    $connection = getConnection();
    if (!isset($connection)) {
        return ["error"];
    }
    $sql = "SELECT `name`, `description` FROM `products`;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    $products = [];
    foreach ($data as $number => $row) {
        $products[$number]["name"] = $row["name"];
        $products[$number]["description"] = $row["description"];
    }
    return $products;
}

$products = getProductList();

$templateEngine->showContent("../templates/kate6/top.tpl");

foreach ($products as $number => $product) {
    $templateEngine->setParameters([
        "name" => $product["name"],
        "description" => $product["description"],
    ]);
    $templateEngine->showContent("../templates/kate6/product.tpl");
}
$templateEngine->showContent("../templates/kate6/bottom.tpl");