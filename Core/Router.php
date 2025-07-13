<?php
class Router
{
    private array $routes = [
        'test' => ['TestController', 'test'],
        'login' => ['AuthController', 'showLoginForm'],
        'login-submit' => ['AuthController', 'handleLogin'],
        'conexion' => ['AuthController', 'login'],
        'register' => ['AuthController', 'showRegisterForm'],
        'register-submit' => ['AuthController', 'handleRegister'],
        'home' => ['Controller', 'showHome'],
        'logout' => ['AuthController', 'logout'],
        'recipe/create' => ['RecipeController', 'showCreateRecipe'],
        'recipe/my_recipe' => ['RecipeController', 'handleRecipeCard'],
        'recipe-submit' => ['RecipeController', 'handleCreateRecipe']
    ];
    /**
     * Fonction qui gère la redirection vers le contrôleur et l'action appropriés.
     * Elle vérifie si la route existe dans le tableau des routes.
     * Si oui, elle instancie le contrôleur et appelle l'action correspondante.
     * Si non, elle affiche un message d'erreur 404.
     */
    public function dispatch()
    {
        if (isset($this->routes[$this->getRouter()])) {
            [$controller, $action] = $this->routes[$this->getRouter()];

            $controller = ucfirst($controller);
            $controllerFile = "../Controllers/" . $controller . ".php";

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $instance = new $controller();
                if (method_exists($instance, $action)) {
                    $instance->$action();
                } else {
                    echo "Méthode '$action' introuvable.";
                }
            } else {
                echo "Contrôleur '$controller' introuvable.";
            }
        } else {
            //A faire : creer une vue d'erreur 404
            echo "<h3>ERREUR 404 - Page non trouvé.</h3>";
        }
    }

    /**
     * Fonction qui récupère la route actuelle depuis les paramètres GET.
     * Si aucun paramètre n'est défini, elle retourne "home" par défaut.
     * @return string La route actuelle.
     */
    private function getRouter(): string
    {
        if (isset($_GET['page'])) {
            return $_GET['page'];
        }
        return "home";
    }
}
