<?php
class Controller
{
    /**
     * Fonction qui gère l'affichage de la page d'accueil.
     */
    public function showHome()
    {
        require_once "../Views/home/home.php";
    }
}
