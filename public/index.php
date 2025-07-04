<?php
require_once "../config/helpers.php";
session_start();
$isConnected = Helpers::isAuthenticated();
if ($isConnected) {
    $uuid = $_SESSION['UUID'];
    $username = $_SESSION['username'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php if (Helpers::isFlashSession()) {
        include_once "../Views/partials/flash.php";
    } ?>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="?page=home">Chill Meal</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="?page=home">Accueil</a>
                        </li>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Compte
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                if (!$isConnected) {
                                ?>
                                    <li><a class="dropdown-item" href="?page=login">Se connecter</a></li>
                                    <li><a class="dropdown-item" href="?page=register">S'inscrire</a></li>
                                <?php
                                } else {
                                ?>
                                    <li class="text-center fw-bold mb-2">Mon compte :</li>
                                    <li><a class="dropdown-item" href="#"><?= ucfirst($username) ?></a></li>
                                    <li><a class="dropdown-item" href="?page=recipe/create">Créer une nouvelle recette</a></li>
                                    <li><a class="dropdown-item" href="?page=recipe/my_recipe">Consulter mes recettes</a></li>
                                    <li><a class="dropdown-item" href="?page=logout">Se déconnecter</a></li>
                                    <?php
                                    if ($_SESSION['UUID'] === "541b425f-580e-11f0-97e1-581122c7a692") {
                                    ?>
                                        <li>
                                            <hr>
                                        </li>
                                        <li class="text-center fw-bold mb-2">Mode développeur :</li>
                                        <li><a class="dropdown-item" href="?page=test">Tester la fonction</a></li>
                                    <?php } ?>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php
    require_once "../Core/Router.php";
    $router = new Router();
    $router->dispatch();
    ?>
</body>

</html>