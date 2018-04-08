<?php

    define("DB_FIELDS", ["id", "name", "framework", "mark", "description"]);

    function getParametersFromPanel(): array
    {
        $name = isset($_POST["languageName"]) ? $_POST["languageName"] : null;
        $framework = isset($_POST["languageFramework"]) ? $_POST["languageFramework"] : null;
        $mark = isset($_POST["languageMark"]) ? $_POST["languageMark"] : null;
        $parameters = [
            DB_FIELDS[1] => $name,
            DB_FIELDS[2] => $framework,
            DB_FIELDS[3] => $mark,
        ];
        return $parameters;
    }

    function getQuery(array $parameters): string
    {
        $query = "SELECT * FROM languages ";
        $conditionsCount = 0;
        foreach ($parameters as $key => $value) {
            if ($value != null) {
                if ($conditionsCount == 0) {
                    $query .= " WHERE ";
                }
                if ($conditionsCount > 0) {
                    $query .= " AND ";
                }
                $query .= " $key = '$value' ";
                $conditionsCount++;
            }
        }
        return $query;
    }

    function getConnectionToDatabase(): mysqli
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

    function getArrayByQueryResult($queryResult): array
    {
        $dataArray = [];
        $rowNumber = 0;
        while ($row = $queryResult->fetch_assoc()) {
            foreach (DB_FIELDS as $value) {
                $dataArray[$rowNumber][$value] = $row[$value];
            }
            $rowNumber++;
        }
        return $dataArray;
    }

    function getDataArrayByQuery(string $query): array
    {
        $connection = getConnectionToDatabase();
        if (isset($connection)) {
            if (($data = ($connection->query($query))) === false) {
                return [];
            }
            $connection->close();
            return getArrayByQueryResult($data);
        } else {
            return [];
        }
    }

    function getTableByArray(array $array): string
    {
        if (count($array) > 0) {
            $resultString = "<table border='1'>";
            $resultString .= <<< HEADER
            <tr>
                <th>id</th>
                <th>name</th>
                <th>framework</th>
                <th>mark</th>
                <th>description</th>
            </tr>
HEADER;
            foreach ($array as $value) {
                $resultString .= "<tr>";
                foreach ($value as $innerValue) {
                    $resultString .= "<td>$innerValue</td>";
                }
                $resultString .= "</tr>";
            }
            $resultString .= "</table>";
            return $resultString;
        } else {
            return "";
        }
    }

    function getReply(): string
    {
        $parameters = getParametersFromPanel();
        $query = getQuery($parameters);
        $dataArray = getDataArrayByQuery($query);
        $reply = getTableByArray($dataArray);
        return $reply;
    }

    function getCurrentTime()
    {
        return microtime(true);
    }

    function getTimeDifference(float $start, float $finish): float
    {
        return round((($finish - $start) / 1000), 7);
    }

    function getReplyStat(): array
    {
        $startTime = getCurrentTime();

        $reply = getReply();

        $finishTime = getCurrentTime();
        $queryTime = getTimeDifference($startTime, $finishTime);

        $replyStat = [
            "reply" => $reply,
            "timeSegment" => "$queryTime ms",
            "RAM" => memory_get_usage() . " b",
        ];
        return $replyStat;
    }