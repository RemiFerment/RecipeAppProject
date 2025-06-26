<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="./js/scripts.js" defer></script>
</head>

<body>
    <header>
        <h1>Application Recette</h1>
        <ul>
            <li><a href="?page=home">Accueil</a></li>
            <li><a href="?page=login">Connexion</a></li>
            <li><a href="?page=register">S'inscrire</a></li>
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