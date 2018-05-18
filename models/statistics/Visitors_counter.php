<?php

class Visitors_counter
{
    private $pageName;
    private $connection;
    private $currentDate;

    public function __construct(string $pageName)
    {
        $this->pageName = $pageName;
        $this->currentDate = '13.05.2018';//date("d.m.Y");
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

    private function getVisitId(string $date, string $siteName): int
    {
        $sql = <<< SQL
SELECT `visit`.`id` FROM `visits` `visit`
           JOIN `sites` `site`
             ON `site`.`name` = :pageName
           JOIN `days` `day`
             ON `day`.`day` = :currentDate
           JOIN `attendance` `att`
             ON `att`.`site_id` = `site`.`id` AND `att`.`day_id` = `day`.`id` AND `att`.`visit_id` = `visit`.`id`;
SQL;
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            "pageName" => $siteName,
            "currentDate" => $date,
        ]);
        return $statement->fetch(PDO::FETCH_NUM)[0] ?? -1;
    }

    private function getEmpyVisitId(): int
    {
        $sql = "SELECT `id` FROM `visits` WHERE `count` = 0;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_NUM)[0];
    }

    private function addNewVisit(): bool
    {
        $sql = "INSERT INTO `visits` (`count`) VALUE (0);";
        $statement = $this->connection->prepare($sql);
        return $statement->execute();
    }

    private function getDayId(string $date): int
    {
        $sql = "SELECT `day`.`id` FROM `days` `day` WHERE `day` = :currentDate;";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            "currentDate" => $date,
        ]);
        return $statement->fetch(PDO::FETCH_NUM)[0] ?? -1;
    }

    private function addNewDay(string $date): bool
    {
        $sql = "INSERT INTO `days` (`day`) value (:currentDate)";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            "currentDate" => $date,
        ]);
    }

    private function getSiteId(string $siteName): int
    {
        $sql = "SELECT `site`.`id` FROM `sites` `site` WHERE `site`.`name` = :siteName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            "siteName" => $siteName,
        ]);
        return $statement->fetch(PDO::FETCH_NUM)[0] ?? -1;
    }

    private function addNewAttendance(int $dateId, int $siteId, int $visitId): bool
    {
        $sql = "INSERT INTO `attendance` (`day_id`, `site_id`, `visit_id`) VALUES (:currentDateId, :siteId, :visitId);";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            "currentDateId" => $dateId,
            "siteId" => $siteId,
            "visitId" => $visitId,
        ]);
    }

    private function addNewRecord(string $date, string $siteName): bool
    {
        $this->addNewVisit();
        $visitId = $this->getEmpyVisitId();
        $dateId = $this->getDayId($date);
        if ($dateId === -1) {
            $this->addNewDay($date);
            $dateId = $this->getDayId($date);
        }
        $siteId = $this->getSiteId($siteName);

        return $this->addNewAttendance($dateId, $siteId, $visitId);
    }

    private function incrementVisit(string $visitId): bool
    {
        $sql = "UPDATE `visits` SET `count` = `count` + 1 WHERE `id` = :id;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            "id" => $visitId,
        ]);
    }

    public function getVisitsAmount(): int
    {
        $sql = <<< SQL
SELECT `visit`.`count` FROM `visits` `visit`
           JOIN `sites` `site`
             ON `site`.`name` = :pageName
           JOIN `days` `day`
             ON `day`.`day` = :currentDate
           JOIN `attendance` `att`
             ON `att`.`site_id` = `site`.`id` AND `att`.`day_id` = `day`.`id` AND `att`.`visit_id` = `visit`.`id`;
SQL;
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            "pageName"     => $this->pageName,
            "currentDate"  => $this->currentDate,
        ]);
        return $statement->fetch(PDO::FETCH_NUM)[0] ?? -1;
    }

    public function updateStatistics(): void
    {
        $visitId = $this->getVisitId($this->currentDate, $this->pageName);
        if ($visitId === -1) {
            $this->addNewRecord($this->currentDate, $this->pageName);
            $visitId = $this->getVisitId($this->currentDate, $this->pageName);
        }
        $this->incrementVisit($visitId);
    }
}