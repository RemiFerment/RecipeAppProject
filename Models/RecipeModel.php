<?php
require_once "../Models/Entities/Recipe.php";
require_once "../config/database.php";

class RecipeModel
{

    //Création d'une recette :
    //Ajout de la recette dans la base de donnée via le formulaire
    public function createRecipe(Recipe $recipe)
    {
        $pdo = Database::getConnection();
        $request = "INSERT INTO recipe(user_id,title,content,created_at,updated_at) VALUES (:user_id,:title,:content,NOW(),NOW())";
        $statement = $pdo->prepare($request);
        $statement->bindValue(":user_id", $recipe->getUserId(), PDO::PARAM_STR);
        $statement->bindValue(":title", $recipe->getTitle(), PDO::PARAM_STR);
        $statement->bindValue(":content", $recipe->getContent(), PDO::PARAM_STR);
        if ($statement->execute()) {
            Helpers::setFlash("La recette a été ajoutée avec succès !", "success");
            header("Location: ?page=home");
            exit;
        } else {
            Helpers::setFlash("Un problème est survenu, la recette n'a pas été ajouté", "danger");
            header("Location: ?page=recipe/create");
            exit;
        }
    }
    //Récupération du dernier id ajouté par l'utilisateur
    public function getLastRecipeID(string $UUID): ?int
    {
        $pdo = Database::getConnection();
        $request = "SELECT id FROM recipe WHERE user_id = :UUID";
        $statement = $pdo->prepare($request);
        $statement->bindValue(":UUID", $UUID);
        if ($statement->execute()) {
            $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);
            return end($queryResult)['id'];
        }
        return null;
    }
}
