<?php
require_once ROOT_DIR . "/config/Logger.php";
function handlePhpError(int $errno, string $errstr, string $errfile, int $errline): bool
{
    $message = "[$errno] \"$errstr\" dans \"$errfile\" à la ligne \"$errline\".";
    Logger::logError($message, "PHP_ERROR");

    Helpers::ErrorFlash("Une erreur interne est survenue. Veuillez réessayer plus tard.", "home");
    return true;
}
function handlePhpException(Throwable $exception): bool
{
    $eMessage =  $exception->getMessage();
    $eCode = $exception->getCode();
    $eLine = $exception->getLine();
    $eFile = $exception->getFile();
    $message = "[$eCode] \"$eMessage\" dans \"$eFile\" à la ligne \"$eLine\"";
    Logger::logException($message, "PHP_EXCEPTION");

    Helpers::ErrorFlash("Une erreur interne est survenue. Veuillez réessayer plus tard.", "home");
    return true;
}

set_error_handler("handlePhpError");
set_exception_handler("handlePhpException");
