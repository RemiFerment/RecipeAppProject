<?php
require_once "../Models/Entities/Recipe.php";
require_once "../Models/Entities/Ingredient.php";
require_once "../Models/Entities/Ingredient_recipe.php";
require_once "../config/database.php";

class RecipeModel
{
    //Création d'une recette :
    //Ajout de la recette dans la base de donnée via le formulaire
    public function createRecipe(Recipe $recipe)
    {
        $pdo = Database::getConnection();
        $pdo->beginTransaction();
        $request = "INSERT INTO recipe(user_id,title,content,created_at,updated_at) VALUES (:user_id,:title,:content,NOW(),NOW())";
        $statement = $pdo->prepare($request);
        $statement->bindValue(":user_id", $recipe->getUserId(), PDO::PARAM_STR);
        $statement->bindValue(":title", $recipe->getTitle(), PDO::PARAM_STR);
        $statement->bindValue(":content", $recipe->getContent(), PDO::PARAM_STR);
        if ($statement->execute()) {
            $allIngredient = $this->getAllIngredients();
            $recipeID = $pdo->lastInsertId();
            $pdo->commit();
            if ($allIngredient !== null) {
                for ($i = 0; $i <= count($allIngredient); $i++) {
                    $ingredient = $this->AddIngredient($allIngredient['ingredients'][$i]);
                    $amount = $allIngredient['amounts'][$i];
                    $unit_id = $allIngredient['units'][$i];
                    $this->AddIngredient_Recipe($recipeID, $ingredient->getId(), $amount, $unit_id);
                }
            }
            Helpers::setFlash("La recette a été ajoutée avec succès !", "success");
            header("Location: ?page=home");
            exit;
        } else {
            Helpers::setFlash("Un problème est survenu, la recette n'a pas été ajouté", "danger");
            header("Location: ?page=recipe/create");
            exit;
        }
    }

    //Récupère la totalité des ingrédients sous forme de tableau
    public function getAllIngredients(): ?array
    {
        if (isset($_POST['ingredient']) && isset($_POST['amount']) && isset($_POST['unit'])) {
            $ingredients = $_POST['ingredient'];
            $amount = $_POST['amount'];
            $unit_measure = $_POST['unit'];
            return [
                "ingredients" => $ingredients,
                "amounts" => $amount,
                "units" => $unit_measure,
            ];
        } else {
            return null;
        }
    }

    public function AddIngredient(string $ingredientName): ?Ingredient
    {
        $ingredientName = ucfirst(strtolower($ingredientName));
        $pdo = Database::getConnection();
        $getIngredientRequest = "SELECT id,name FROM ingredient WHERE name = :ingredientName";
        $stmGetIngredient = $pdo->prepare($getIngredientRequest);
        $stmGetIngredient->bindValue(":ingredientName", $ingredientName);
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
        //AJOUTER AU SYSTEME DE JOURNALISATION
        echo '<h3 class="text-center p-2 bg-danger">Un problème de connexion est survenue, veuillez réessayer plus tard.</h3>';
        return null;
    }
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
        if ($stm->execute()) {
            $IngRec->setId($pdo->lastInsertId());
            $pdo->commit();
            return $IngRec;
        }
        return null;
    }
}
