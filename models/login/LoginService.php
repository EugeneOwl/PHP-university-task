<?php

class LoginService
{
    private $connection;

    private const LOGIN_DOES_NOT_EXIST = "Username does not exist.";
    private const INVALID_PASSWORD = "Password is not valid.";

    private const ROLE_ADMIN = "admin";
    private const ROLE_USER = "user";

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=localhost",
                "root",
                "6031_MySQL_1994_php"
                );
        } catch (Exception $exception) {
            die("Inner problems with the database.");
        }
    }

    public function verifyLogin(?string $submited, ?string $name, ?string $password): array
    {
        $result = [
            "isValid" => false,
            "loginError" => "",
            "passwordError" => "",
        ];
        if (!isset($submited)) {
            return $result;
        }
        $result["loginError"] = $this->doesLoginExist($name) ? "" : self::LOGIN_DOES_NOT_EXIST;
        $result["passwordError"] = $this->isPasswordCorrect($name, $password) ? "" : self::INVALID_PASSWORD;
        $result["isValid"] = empty($result["loginError"]) && empty($result["passwordError"]);
        if ($result["isValid"]) {
            $this->setAdminMode($name);
        }
        return $result;
    }

    private function doesLoginExist(?string $login): bool
    {
        if (!isset($login)) {
            return false;
        }
        $sql = "SELECT `user`.`id` FROM `loginWT`.`users` `user` WHERE `user`.`name` = :name";
        $statement = $this->connection->prepare($sql);
        $statement->execute(["name" => $login]);
        return (count($statement->fetchAll()) == 1);
    }

    private function isPasswordCorrect(?string $login, ?string $password): bool
    {
        if (!isset($login) || !isset($password)) {
            return false;
        }
        $sql = "SELECT `user`.`password` FROM `loginWT`.`users` `user` WHERE `user`.`name` = :name";
        $statement = $this->connection->prepare($sql);
        $statement->execute(["name" => $login]);
        $realPassowrd = $statement->fetch(PDO::FETCH_ASSOC)["password"];
        return (crypt($password, $realPassowrd) == $realPassowrd);
    }

    public function setAdminMode(string $name): void
    {
        $sql = "SELECT `user`.`role` FROM `loginWT`.`users` `user` WHERE `user`.`name` = :name";
        $statement = $this->connection->prepare($sql);
        $statement->execute(["name" => $name]);
        $role = $statement->fetch(PDO::FETCH_ASSOC)["role"];
        setcookie("admin", $role == self::ROLE_ADMIN);
    }
}