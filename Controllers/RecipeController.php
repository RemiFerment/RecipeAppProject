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
     * @throws Exception
     */
    public function showCreateRecipe(): void
    {
        if (Helpers::isAuthenticated()) {
            require_once "../Views/recipe/create.php";
        } else {
            Helpers::ErrorFlash("Veuillez-vous connecter.", "login");
        }
    }

    /**
     * Fonction qui gère la création des recettes.
     * Si l'utilisateur est connecté, et si les variavble POST du titre et du contenu sont bien activés : 
     * Création de la recette réussi.
     * @return void
     * @throws Exception
     */
    public function handleCreateRecipe()
    {
        if (isset($_POST['title']) && isset($_POST['content']) && Helpers::isAuthenticated()) {
            $newRecipe = new Recipe($_SESSION['UUID'], $_POST['title'], $_POST['content']);
            $recipeModel = new RecipeModel();
            $recipeModel->createRecipe($newRecipe);
        }
    }

    /**
     * Fonction qui gère l'affichage des cartes de recettes.
     * Si l'utilisateur n'est pas connecté, un message flash est affiché, exigeant une connexion.
     * Si l'utilisateur est connecté, on récupère les recettes de l'utilisateur et on les affiche.
     * @return void
     */
    public function handleRecipeCard()
    {
        if (!isset($_SESSION['UUID'])) {
            Helpers::ErrorFlash("Veuillez-vous connecter.", "login");
            return;
        }
        $user_id = $_SESSION['UUID'];
        $recipeModel = new RecipeModel();
        $allRecipe = $recipeModel->GetRecipeCards($user_id);
        foreach ($allRecipe as $recipe) {
            $recipeTitle = $recipe['recipeTitle'];
            $recipeContent = $recipe['recipeContent'];
            $lastUpdateTime = $recipe['updated_at'];
            $ingredients = $recipe['ingredients'];
            include "../Views/recipe/recipeCard.php";
        }
    }
}
