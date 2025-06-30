<?php
class Router
{
    private array $routes = [
        'login' => ['AuthController', 'showLoginForm'],
        'login-submit' => ['AuthController', 'handleLogin'],
        'conexion' => ['AuthController', 'login'],
        'register' => ['AuthController', 'showRegisterForm'],
        'register-submit' => ['AuthController', 'handleRegister'],
        'home' => ['Controller', 'showHome'],
        'logout' => ['AuthController', 'logout'],
        'recipe/create' => ['RecipeController', 'showRecipe']
    ];
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
            echo "<h3>ERREUR 404 - Page non trouvé.</h3>";
        }
    }

    private function getRouter(): string
    {
        if (isset($_GET['page'])) {
            return $_GET['page'];
        }
        return "home";
    }
}
