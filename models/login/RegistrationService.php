<?php

class RegistrationService
{
    private $connection;

    private const INVALID_LOGIN = "Username is not valid";
    private const LOGIN_DOES_EXIST = "Username already exists.";
    private const EASY_PASSWORD = "Password is too easy.";
    private const NOT_SAME_PASSWORDS = "Passwords are not same.";

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

    public function verifyLogup(?string $submited, ?string $name, ?string $password, ?string $secondPassword): array
    {
        $result = [
            "isValid" => false,
            "loginError" => "",
            "passwordError" => "",
        ];
        if (!isset($submited)) {
            return $result;
        }

        $result["loginError"] = $this->isLoginValid($name) ? "" : self::INVALID_LOGIN;
        if (empty($result["loginError"])) {
            $result["loginError"] = $this->isLoginUnique($name) ? "" : self::LOGIN_DOES_EXIST;
        }

        $result["passwordError"] = $this->isPasswordStrong($password) ? "" : self::EASY_PASSWORD;
        if (empty($result["passwordError"])) {
            $result["passwordError"] = $this->arePasswordsSame($password, $secondPassword) ? "" : self::NOT_SAME_PASSWORDS;
        }
        $result["isValid"] = empty($result["loginError"]) && empty($result["passwordError"]);
        if ($result["isValid"]) {
            $this->recognizeRegistration($name, $password);
            $this->setAdminMode($name);
        }
        return $result;
    }

    private function isLoginValid(?string $login): bool
    {
        return !empty($login);
    }

    private function isLoginUnique(?string $login): bool
    {
        if (!isset($login)) {
            return false;
        }
        $sql = "SELECT `user`.`id` FROM `loginWT`.`users` `user` WHERE `user`.`name` = :name";
        $statement = $this->connection->prepare($sql);
        $statement->execute(["name" => $login]);
        return (count($statement->fetchAll()) == 0);
    }

    private function isPasswordStrong(?string $password): bool
    {
        if (!isset($password)) {
            return false;
        }
        if (strlen($password) < 3) {
            return false;
        }
        return true;
    }

    private function arePasswordsSame(?string $password, ?string $secondPassword): bool
    {
        if (!isset($password) || !isset($secondPassword)) {
            return false;
        }
        return $password == $secondPassword;
    }

    private function recognizeRegistration(string $login, string $password): bool
    {
        $password = crypt($password);
        $sql = "insert into `loginWT`.`users` (`name`, `role`, `password`) VALUES (:login, :role, :password);";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            "login" => $login,
            "role" => self::ROLE_USER,
            "password" => $password,
        ]);
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