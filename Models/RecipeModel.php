<?php
require_once "../Models/Entities/Recipe.php";
require_once "../Models/Entities/Ingredient.php";
require_once "../Models/Entities/Ingredient_recipe.php";
require_once "../config/database.php";

class RecipeModel
{

    /**
     * Fonction qui gère la création d'une recette.
     * Elle prend en paramètre un objet Recipe et insère les données dans la base de données.
     * 
     * Si l'insertion réussit, elle ajoute les ingrédients associés à la recette.
     * 
     * Si l'insertion échoue, elle affiche un message d'erreur.
     * @param Recipe $recipe
     * @return void
     */
    public function createRecipe(Recipe $recipe)
    {
        $pdo = Database::getConnection();
        $pdo->beginTransaction();
        $request = "INSERT INTO recipe(user_id,title,content,created_at,updated_at) VALUES (:user_id,:title,:content,NOW(),NOW())";
        $statement = $pdo->prepare($request);
        $statement->bindValue(":user_id", $recipe->getUserId(), PDO::PARAM_STR);
        $statement->bindValue(":title", $recipe->getTitle(), PDO::PARAM_STR);
        $statement->bindValue(":content", $recipe->getContent(), PDO::PARAM_STR);
        try {
            if ($statement->execute()) {
                $allIngredient = $this->getAllIngredientsCreate();

                $recipeID = $pdo->lastInsertId();
                $pdo->commit();
                if ($allIngredient !== null) {
                    foreach ($allIngredient as $anIngredient) {
                        $ingredient = $this->AddIngredient($anIngredient['ingredient']);
                        $this->AddIngredient_Recipe($recipeID, $ingredient->getId(), $anIngredient['amount'], $anIngredient['unit']);
                    }
                }
                Helpers::SuccessFlash("La recette a été ajoutée avec succès !", "home");
            } else {
                Helpers::ErrorFlash("Un problème est survenu, la recette n'a pas été ajouté", "recipe/create");
            }
        } catch (ErrorException $e) {
            $eMsg = $e->getMessage();
            throw new ErrorException($eMsg);
        }
    }

    /**
     * Fonction qui récupère les ingrédients du formulaire de création de recette.
     * Elle vérifie si les variables POST pour les ingrédients, les quantités et les unités sont définies.
     * 
     * Si oui, elle crée un tableau d'ingrédients avec leurs quantités et unités.
     * @return array|null Un tableau d'ingrédients ou null si les données ne sont pas valides.
     */
    public function getAllIngredientsCreate(): ?array
    {
        if (isset($_POST['ingredient']) && isset($_POST['amount']) && isset($_POST['unit'])) {
            $allIngredient = [];
            for ($i = 0; $i < count($_POST['ingredient']); $i++) {
                $ingredients = [
                    "ingredient" => $_POST['ingredient'][$i],
                    "amount" => $_POST['amount'][$i],
                    "unit" => $_POST['unit'][$i]
                ];
                $allIngredient[] = $ingredients;
            }
            return $allIngredient;
        } else {
            return null;
        }
    }

    /**
     * Fonction qui ajoute un ingrédient à la base de données.
     * Elle vérifie si l'ingrédient existe déjà.
     * 
     * Si oui, elle retourne l'objet Ingredient correspondant.
     * 
     * Si non, elle crée un nouvel ingrédient et le retourne.
     * 
     * @param string $ingredientName Le nom de l'ingrédient à ajouter.
     * @return Ingredient|null L'objet Ingredient créé ou trouvé, ou null en cas d'erreur.
     */
    public function AddIngredient(string $ingredientName): ?Ingredient
    {
        $ingredientName = ucfirst(strtolower($ingredientName));
        $pdo = Database::getConnection();
        $getIngredientRequest = "SELECT id,name FROM ingredient WHERE name = :ingredientName";
        $stmGetIngredient = $pdo->prepare($getIngredientRequest);
        $stmGetIngredient->bindValue(":ingredientName", $ingredientName);
        try {

            if ($stmGetIngredient->execute()) {
                $queryResult = $stmGetIngredient->fetch(PDO::FETCH_ASSOC);
                if ($queryResult) {
                    $newIngredient = new Ingredient($queryResult['id'], $queryResult['name']);
                    return $newIngredient;
                } else {
                    $createIngredientRequest = "INSERT INTO ingredient (name) VALUE (:ingredientName)";
                    $pdo->beginTransaction();
                    $stmCreateIngredient = $pdo->prepare($createIngredientRequest);
                    $stmCreateIngredient->bindValue(":ingredientName", $ingredientName);
                    if ($stmCreateIngredient->execute()) {
                        $newIngredient = new Ingredient($pdo->lastInsertId(), $ingredientName);
                        $pdo->commit();
                        return $newIngredient;
                    }
                }
            }
        } catch (ErrorException $e) {
            $eMsg = $e->getMessage();
            throw new ErrorException($eMsg);
        }
        //AJOUTER AU SYSTEME DE JOURNALISATION
        echo '<h3 class="text-center p-2 bg-danger">Un problème de connexion est survenue, veuillez réessayer plus tard.</h3>';
        return null;
    }

    /**
     * Fonction qui ajoute un ingrédient à une recette.
     * Elle prend en paramètres l'ID de la recette, l'ID de l'ingrédient, la quantité et l'unité de mesure.
     * 
     * Elle crée un objet IngredientRecipe et l'insère dans la base de données.
     * 
     * Si l'insertion réussit, elle retourne l'objet IngredientRecipe créé.
     * @param int $recipID L'ID de la recette.
     * @param int $ingredientID L'ID de l'ingrédient.
     * @param float $amount La quantité de l'ingrédient.
     * @param int $unitID L'ID de l'unité de mesure.
     * @return IngredientRecipe|null L'objet IngredientRecipe créé ou null en cas d'erreur
     */
    public function AddIngredient_Recipe(int $recipID, int $ingredientID, float $amount, int $unitID): ?IngredientRecipe
    {
        $IngRec = new IngredientRecipe($recipID, $ingredientID, $amount, $unitID);
        $pdo = Database::getConnection();
        $pdo->beginTransaction();
        $addRecipe_IngredientRequest = "INSERT INTO ingredient_recipe (recipe_id,ingredient_id,amount,unit_measure_id) VALUES (:recipeID,:ingredientID,:amount,:unitID)";
        $stm = $pdo->prepare($addRecipe_IngredientRequest);
        $stm->bindValue(":recipeID", $IngRec->getRecipeId());
        $stm->bindValue(":ingredientID", $IngRec->getIngredientId());
        $stm->bindValue(":amount", $IngRec->getQuantity());
        $stm->bindValue(":unitID", $IngRec->getUnitMeasureId());
        try {
            if ($stm->execute()) {
                $IngRec->setId($pdo->lastInsertId());
                $pdo->commit();
                return $IngRec;
            }
        } catch (ErrorException $e) {
            $eMsg = $e->getMessage();
            throw new ErrorException($eMsg);
        }
        return null;
    }

    /**
     * Fonction qui récupère les recettes de l'utilisateur.

     * @param string $UUID L'UUID de l'utilisateur.
     * @return array|null Un tableau de recettes ou null si aucune recette n'est trouvée.
     */
    public function GetRecipeCards(string $UUID): ?array
    {
        $pdo = Database::getConnection();
        $getAllRecipe_Request =
            "SELECT 
        id,
        title AS recipeTitle,
        content AS recipeContent,
        updated_at
        FROM recipe 
        WHERE user_id = :user_id";
        $stm = $pdo->prepare($getAllRecipe_Request);
        $stm->bindValue(":user_id", $UUID);
        try {
            if ($stm->execute()) {
                $recipes = $stm->fetchAll(PDO::FETCH_ASSOC);
                $test = [];
                foreach ($recipes as $recipe) {
                    $ingredients = $this->GetIngredientForRecipe($recipe['id']);
                    $test[] = array_merge($recipe, $ingredients);
                }
                return $test;
            }
        } catch (ErrorException $e) {
            $eMsg = $e->getMessage();
            throw new ErrorException($eMsg);
        }
        return null;
    }

    /**
     * Fonction qui récupère les ingrédients d'une recette.
     * 
     * @param int $recipeID L'ID de la recette.
     * @return array|null Un tableau d'ingrédients ou null si aucune donnée n'est trouvée.
     */
    public function GetIngredientForRecipe(int $recipeID): ?array
    {
        $pdo = Database::getConnection();
        $getAllIngredient_Request =
            "SELECT
            ingredient.name AS ingredientName,
            ingredient_recipe.amount,
            unit_measure.name AS unit
            FROM ingredient_recipe 
            JOIN ingredient ON ingredient_recipe.ingredient_id = ingredient.id
            JOIN unit_measure ON ingredient_recipe.unit_measure_id = unit_measure.id
            JOIN recipe ON ingredient_recipe.recipe_id = recipe.id
            WHERE recipe.id = :recipe_id;
        ";
        $stm = $pdo->prepare($getAllIngredient_Request);
        $stm->bindValue(":recipe_id", $recipeID);
        try {
            if ($stm->execute()) {
                return ["ingredients" => $stm->fetchAll(PDO::FETCH_ASSOC)];
            }
        } catch (ErrorException $e) {
            $eMsg = $e->getMessage();
            throw new ErrorException($eMsg);
        }
        return null;
    }
}
