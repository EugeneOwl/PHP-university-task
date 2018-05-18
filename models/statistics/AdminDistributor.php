<?php

require_once "models/statistics/Sender.php";

class AdminDistributor
{
    private $connection;
    private $sender;

    public function __construct()
    {
        $this->sender = new Sender();
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

    private function getAllEmails(): array
    {
        $sql = "SELECT `subscriber`.`email` FROM `subscribers` `subscriber`;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $emails = [];
        foreach ($data as $row) {
            $emails[] = $row["email"];
        }
        return $emails;
    }

    public function distributeMessage(?string $message): bool
    {
        if (empty($message)) {
            return false;
        }
        $emails = $this->getAllEmails();
        foreach ($emails as $email) {
            $this->sender->sendMail($email, $message, "Web site", "Distribution");
        }
        return true;
    }
}