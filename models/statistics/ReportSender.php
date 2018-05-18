<?php

require_once "models/statistics/Sender.php";

class ReportSender
{
    private $pageName;
    private $connection;
    private $sender;
    private $adminMail = "eugenevaleska1994@gmail.com";

    public function __construct(string $pageName)
    {
        $this->pageName = $pageName;
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

    private function getRawReportData(string $pageName): array
    {
        $sql = <<< SQL
SELECT `site`.`name`, `day`.`day`, `visit`.`count` FROM (`sites` `site`, `days` `day`, `visits` `visit`)
   JOIN `attendance` `att`
     ON `att`.`site_id` = `site`.`id` AND
     `att`.`day_id` = `day`.`id` AND
     `att`.`visit_id` = `visit`.`id` AND
     `site`.`name` = :pageName;
SQL;
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            "pageName" => $pageName,
        ]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getReport(string $pageName): string
    {
        $data = $this->getRawReportData($pageName);
        $report = "";
        foreach ($data as $number => $row) {
            $report .= $number + 1 . ") " . $row["name"] . " - " . $row["count"] . "\n";
        }
        return $report;
    }

    public function sendReport(): void
    {
        $report = $this->getReport($this->pageName);
        $this->sender->sendMail($this->adminMail, $report, "Web site", "Statistics");
    }
}
