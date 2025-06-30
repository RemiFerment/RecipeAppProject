<?php

class Helpers
{
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['UUID']) && isset($_SESSION['pseudo']);
    }

    public static function isFlashSession()
    {
        if (isset($_SESSION['flash'])) {
            $type = key($_SESSION['flash']);
            include "../Views/partials/flash.php";
        }
    }
    public static function setFlash(string $message, string $type = "neutral"): void
    {
        if ($type !== "success" && $type !== "warning" && $type !== "error") {
            $type = "neutral";
        }
        $_SESSION['flash'][$type] = $message;
    }
}
