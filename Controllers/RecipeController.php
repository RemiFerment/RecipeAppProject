<?php
require_once "../config/helpers.php";
require_once "../Models/Entities/Recipe.php";
require_once "../Models/RecipeModel.php";
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

    public function handleCreateRecipe()
    {
        if (isset($_POST['title']) && isset($_POST['content']) && Helpers::isAuthenticated()) {
            $newRecipe = new Recipe($_SESSION['UUID'], $_POST['title'], $_POST['content']);
            $recipeModel = new RecipeModel();
            $recipeModel->createRecipe($newRecipe);
        }
    }
}
