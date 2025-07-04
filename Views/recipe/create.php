<?php
require_once "../Views/recipe/ingredient.php";
?>
<div class="container-fluid justify-content-center text-right bg-dark mt-3 w-25 p-3 rounded">
    <form method="post" action="?page=recipe-submit">
        <header class="text-center my-3">
            <h2>Créer une nouvelle recette</h2>
        </header>
        <label for="title" class="form-label">Nom de la recette :</label><br>
        <input type="text" name="title" id="title" required maxlength="255" class="form-control" required><br><br>

        <label for="ingredient" class="form-label">Ingrédients :</label><br>
        <div class="ingredients">
        </div>
        <br>
        <input type="button" value="+" id="add-button" class="btn btn-secondary"><br> <br>

        <label for="content" class="form-label">Contenu</label><br>
        <textarea name="content" id="content" class="form-control" required></textarea> <br> <br>
        <div class="text-center">
            <input type="submit" value="Ajouter la nouvelle recette" class="btn btn-success">
        </div>

    </form>
</div>



<script src="./js/create.js" defer></script>