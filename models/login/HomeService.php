<?php

class HomeService
{
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=127.0.0.1",
                "root",
                "6031_MySQL_1994_php"
            );
        } catch (Exception $exception) {
            die("Inner problems with database.");
        }
    }

    public function selectAllUsers(): array
    {
        $sql = "SELECT `user`.`id`, `user`.`name`, `user`.`role`, `user`.`password`
FROM `loginWT`.`users` `user` LIMIT 300;";
        $statement = $this->connection->prepare($sql);
        $success = $statement->execute();
        if ($success) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getUserListTable(?string $adminMode): string
    {
        $data = $this->selectAllUsers();
        $table = <<< TABLE
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Role</th>
        <th>Password</th>
TABLE;

        if ($adminMode) {
            $table .= "<th>Delete</th>";
        }
        $table .= "</tr>";

        foreach ($data as $number => $row) {
            $table .= "<tr><td>";
            $table .= implode("</td><td>", $row);
            if ($adminMode) {
                $table .= "</td><td><input type='checkbox' value='{$row['id']}' name='delete[]'>";
            }
            $table .= "</td><tr>";
        }
        $table .= "</table>";
        if ($adminMode) {
            $table .= "<input type='submit' value='delete' id='deleteButton'>";
        }
        return $table;
    }

    public function executeDeletion(?string $adminMode, ?array $ids): void
    {
        if (!isset($ids) || !($adminMode)) {
            return;
        }
        $sql = "DELETE FROM `loginWT`.`users` where `id` = :id;";
        $statement = $this->connection->prepare($sql);
        foreach ($ids as $id) {
            $statement->execute(["id" => $id]);
        }
    }
}