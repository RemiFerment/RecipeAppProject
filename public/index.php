<?php
require_once "../config/helpers.php";
session_start();
$isConnected = Helpers::isAuthenticated();
if ($isConnected) {
    $uuid = $_SESSION['UUID'];
    $pseudo = $_SESSION['pseudo'];
}
$specificScript = ""
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppRecipe</title>
    <script src="./js/scripts.js" defer></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php if (Helpers::isFlashSession()) {
        include_once "../Views/partials/flash.php";
    } ?>
    <header>
        <h1>Application Recette</h1>
        <ul>
            <li><a href="?page=home">Accueil</a></li>
            <?php
            if (!$isConnected) {
            ?>
                <li><a href="?page=login">Connexion</a></li>
                <li><a href="?page=register">S'inscrire</a></li>
            <?php
            } else {
            ?>
                <li><a href="#"><?= $pseudo ?></a></li>
                <li><a href="?page=recipe/create">Créer une nouvelle recette</a></li>
                <li><a href="?page=recipe/my_recipe">Consulter mes recettes</a></li>
                <li><a href="?page=logout">Se déconnecter</a></li>
            <?php
            }
            ?>
        </ul>
    </header>
    <main>

    </main>
    <?php
    require_once "../Core/Router.php";
    $router = new Router();
    $router->dispatch();
    ?>
</body>

</html>