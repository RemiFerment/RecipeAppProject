<?php
require_once ROOT_DIR . "/config/helpers.php";
class Logger
{
    //Fonction log qui permet d'écrire dans un fichier log
    //Ajout de la date et de l'heure 
    //Ecrire dans un fichier -> à faire
    static public function logError(string $message, string $type)
    {
        $date = new DateTime();
        $formatDate = $date->format("Y/m/d | H:i:s");
        $content = "$formatDate - [$type] => $message
    
        ===============================================================

";
        Helpers::WriteLogFile("error", $content);
    }
    static public function logException(string $message, string $type)
    {
        $date = new DateTime();
        $formatDate = $date->format("Y/m/d | H:i:s");
        $content = "$formatDate - [$type] => $message
    
        ===============================================================

";
        Helpers::WriteLogFile("exception", $content);
    }
}
