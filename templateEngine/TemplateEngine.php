<?php

class TemplateEngine
{
    public $parameters = [];
    private $content;
    private $pictureFormats = ["png", "jpeg", "jpg"];
    private $configurationFilePath = "";

    public function getConfigurationFilePath(): string
    {
        return $this->configurationFilePath;
    }

    public function setConfigurationFilePath(string $configurationFilePath): void
    {
        if (is_file($configurationFilePath)) {
            $this->configurationFilePath = $configurationFilePath;
        }
    }

    public function setParameters(array $parameters): void
    {
        foreach ($parameters as $key => $val) {
            if (!is_array($val)) {
                $this->parameters[$key] = $val;
            } else {
                $this->setParameters($val);
            }
        }
    }

    private function isImage(string $filePath):string
    {
        return in_array(pathinfo($filePath)["extension"], $this->pictureFormats);
    }

    private function getFileContentByPath(string $filePath): string
    {
        $result = $filePath;
        if (is_file($filePath)) {
            if ($this->isImage($filePath)) {
                $result = "<img src='$filePath' alt='image' width='150' height='150'>";
            } else {
                $result = file_get_contents($filePath);
                if ($result === false) {
                    $result = $filePath . " (problems with opening file)";
                }
            }
        }
        return $result;
    }

    private function getValueByKeyInArray(array $array, string $soughtValueKey): string
    {
        define("NOT_FOUND", "Element not found in config file.");
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (($result = $this->getValueByKeyInArray($value, $soughtValueKey)) !== NOT_FOUND) {
                    return $result;
                }
            } elseif ($key == $soughtValueKey) {
                return $value;
            }
        }
        return NOT_FOUND;
    }

    private function getConfigFileValue(string $key): string
    {
        if (empty($this->configurationFilePath)) {
            $value =  "(Configuration file is not chosen)";
        } else {
            $value = $this->getValueByKeyInArray
            (
                json_decode(
                    file_get_contents($this->configurationFilePath),
                    true
                ),
                $key
            );
        }
        return $value;
    }

    private function getConnectionToDatabase()
    {
        $parameters = [
            "servername" => "localhost",
            "username" => "root",
            "password" => "ubuntu6031",
            "DBname" => "eugeneDB",
        ];
        $connection = new mysqli(
            $parameters["servername"],
            $parameters["username"],
            $parameters["password"],
            $parameters["DBname"]
        );
        if ($connection->connect_errno) {
            return null;
        }
        return $connection;
    }

    private function getDataFromDatabase(mysqli $connection, string $id): string
    {
        $sql = "SELECT name, description FROM languages WHERE id = " . $id;
        if (($data = ($connection->query($sql))) === false) {
            return "Error while passing query.";
        }
        if ($data->num_rows == 0) {
            return "Data not found in database";
        }
        $row = $data->fetch_assoc();
        $languageName = $row["name"];
        $languageDescription = $row["description"];
        $niceData = <<< DATA
        <table width="300">
        <tr>
            <th>
                Name
            </th>
            <th>
                Description
            </th>
        </tr>
        <tr>
            <td>
                $languageName
            </td>
            <td>
                $languageDescription
            </td>
        </tr>
        </table>
DATA;

        return $niceData;
    }

    private function getDataFromDatabaseById(string $id): string
    {
        $connection = $this->getConnectionToDatabase();
        if ($connection == null) {
            return "Error while connecting to DB.";
        }
        return $this->getDataFromDatabase($connection, $id);
    }

    public function showContent(string $tpl): void
    {
        $tempContent = file_get_contents($tpl);

        foreach ($this->parameters as $key => $val) {
            $tempContent = str_replace("{FILE=" . $key . "}", $this->getFileContentByPath($val), $tempContent);
            $tempContent = str_replace("{CONFIG=" . $key . "}", $this->getConfigFileValue($val), $tempContent);
            $tempContent = str_replace("{DB=" . $key . "}", $this->getDataFromDatabaseById($val), $tempContent);
            $tempContent = str_replace("{" . $key . "}", $val, $tempContent);
        }
        $this->content = $tempContent;

        echo $this->content;
    }
}
