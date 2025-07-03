<?php
require_once "../config/helpers.php";
class RecipeController
{
    /**
     * Fonction envoyant à la vue le formulaire de création de recette.
     * Si l'utilisateur n'est pas connecté, un message flash est affiché, exigeant une connexion.
     * @return void
     */
    public function showRecipe(): void
    {
        if (Helpers::isAuthenticated()) {
            require_once "../Views/recipe/create.php";
        } else {
            Helpers::setFlash("Veuillez-vous connecter.", "error");
            header("Location: ?page=login");
            exit;
        }
    }

    public function handleCreateRecipe() {}
}
