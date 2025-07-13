<?php

class Helpers
{
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['UUID']) && isset($_SESSION['username']);
    }

    public static function isFlashSession()
    {
        if (isset($_SESSION['flash'])) {
            $type = key($_SESSION['flash']);
            include "../Views/partials/flash.php";
        }
    }
    private static function setFlash(string $message, string $type = "primary"): void
    {
        if ($type !== "success" && $type !== "warning" && $type !== "danger" && $type !== "neutral") {
            $type = "primary";
        }
        $_SESSION['flash'][$type] = $message;
    }
    public static function NeutralFlash(string $message, string $url)
    {
        self::setFlash($message, "neutral");
        header("Location: ?page=$url");
        exit;
    }
    public static function SuccessFlash(string $message, string $url)
    {
        self::setFlash($message, "success");
        header("Location: ?page=$url");
        exit;
    }
    public static function WarningFlash(string $message, string $url)
    {
        self::setFlash($message, "warning");
        header("Location: ?page=$url");
        exit;
    }
    public static function ErrorFlash(string $message, string $url)
    {
        self::setFlash($message, "danger");
        header("Location: ?page=$url");
        exit;
    }

    public static function WriteLogFile(string $fileName, string $content)
    {
        $fileDir = ROOT_DIR . "/logs/$fileName.log";
        if (file_exists($fileDir)) {
            $file = fopen("$fileDir", "a");
            fwrite($file, $content);
            fclose($file);
        } else {
            throw new Exception("$fileDir do not exist, verify $fileName.", 2001);
        }
    }
}
