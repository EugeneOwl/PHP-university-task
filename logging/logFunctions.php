<?php
    function redirectLogs(string $errorPath, bool $errorsToLog): bool
    {
        $done = ini_set("error_log", $errorPath);
        $done &= ini_set("log_errors", $errorsToLog);
        return $done;
    }