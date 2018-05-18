<?php

class Subscriber
{
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=localhost;dbname=statistics",
                "root",
                "6031_MySQL_1994_php"
            );
        } catch (Exception $exception) {
            echo "Inner database trouble.";
        }
    }

    public function subscribe(?string $email): bool
    {
        if (empty($email)) {
            return false;
        }
        $sql = "INSERT INTO `subscribers` (`email`) value (:email);";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            "email" => $email
        ]);
    }
}