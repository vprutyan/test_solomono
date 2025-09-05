<?php

class ErrorLogging
{
    public static function logError($e)
    {
        // Construct a detailed log message
        $logMessage = sprintf(
            "Caught Exception: '%s' with message '%s' in %s:%d\nStack trace: %s",
            get_class($e),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getTraceAsString()
        );

        // Write the message to the PHP error log
        error_log($logMessage);
    }
}