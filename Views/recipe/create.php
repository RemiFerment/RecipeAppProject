<?php
$specificScript = "create";
require_once "../Views/recipe/ingredient.php";
?>
<form method="post" action="?page=recipe-submit">
    <header>
        <h2>Créer une nouvelle recette</h2>
    </header>
    <label for="recipeTitle">Nom de la recette :</label><br>
    <input type="text" name="recipeTitle" id="recipeTitle" required maxlength="255"><br><br>

    <label for="ingredient">Ingrédients :</label><br>
    <div class="ingredients">
    </div>
    <br>
    <input type="button" value="+" id="add-button"><br> <br>

    <label for="content">Contenu</label><br>
    <textarea name="content" id="content" required></textarea> <br> <br>

    <input type="submit" value="Ajouter la nouvelle recette">
</form>
<script src="./js/<?= $specificScript ?>.js" defer></script>