<div class="d-flex justify-content-center">
    <div class="card text-bg-dark m-3" style="min-width: 20rem;max-width: 20rem;">
        <main class="card-body">
            <h5 class="card-title"><?= $recipeTitle ?></h5>
            <hr>
            <p class="card-text"><?= $recipeContent ?></p>
            <ul class="list-group list-froup-flush bg-dark">

                <?php if (is_array($ingredients)) : ?>
                    <?php foreach ($ingredients as $ingredient) :
                        $ingredientName = $ingredient['ingredientName'] ?? '';
                        $amount = $ingredient['amount'] ?? '';
                        $unit = $ingredient['unit'] ?? '';
                        include "../Views/recipe/ingredientRecipeCard.php";
                    endforeach; ?>
                <?php endif; ?>


            </ul>
            <div class="text-end">
                <a href="#" class="btn btn-success mt-3">Afficher le détail de la recette</a>
            </div>
        </main>
        <footer>
            <p class="card-text text-end px-2"><small class="text-white-50"><?= "Dernière modification : $lastUpdateTime" ?></small></p>
        </footer>
    </div>
</div>