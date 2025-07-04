<?php
require_once "../config/helpers.php";
require_once "../Models/UserModel.php";
class AuthController
{
    public function handleLogin()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $userModel = new UserModel();
            if ($userModel->login($_POST['email'], $_POST['password'])) {
                return;
            } else {
                Helpers::setFlash("L'adresse mail ou le mot de passe ne correspondent pas.", "error");
                header("Location: ?page=login");
                exit;
            }
        }
    }
    public function handleRegister(): void
    {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['checkPassword'])) {
            //Creation de l'objet User avec les données du formulaire
            $user = new User("", $_POST['username'], $_POST['email'], $_POST['password'], false);
            //Création des regex
            $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d])[A-Za-z\d\S]{8,}$/';
            $usernameRegex = '/^.{4,}$/';

            if (!$user->checkUserIntegrity() || !preg_match($passwordRegex, $user->getPassword()) || !preg_match($usernameRegex, $user->getUsername())) {
                Helpers::setFlash("Le formulaire est incomplet et/ou incorrect", "error");
                header("Location: ?page=register");
                exit;
                return;
            }
            if ($user->checkPassword($_POST['checkPassword'])) {
                $userModel = new UserModel();
                $userModel->register($user);
                return;
            } else {
                Helpers::setFlash("Les deux mots de passe saisie sont incorrect.", "error");
                header("Location: ?page=register");
                exit;
                return;
            }
        } else {
            Helpers::setFlash("Le formulaire est incomplet", "error");
            return;
        }
    }
    public function showLoginForm()
    {
        include_once '../Views/auth/login.php';
    }
    public function showRegisterForm()
    {
        include_once '../Views/auth/register.php';
    }
    public function logout(): void
    {
        session_unset();
        session_destroy();
        session_start();
        Helpers::setFlash("Vous avez été déconnecté.", "warning");
        header("Location: ?page=home");
        exit;
    }
}
