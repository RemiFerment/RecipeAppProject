<?php
require_once "../config/helpers.php";
require_once "../Models/UserModel.php";
class AuthController
{
    /**
     * Fonction qui gère la connexion de l'utilisateur.
     * Si la connexion est réussie, l'utilisateur est redirigé vers la page d'accueil.
     * Si la connexion échoue, un message flash est affiché. 
     */
    public function handleLogin(): bool
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $userModel = new UserModel();
            if ($userModel->login($_POST['email'], $_POST['password'])) {
                return true;
            } else {
                Helpers::ErrorFlash("L'adresse mail ou le mot de passe ne correspondent pas.", "login");
            }
        }
        return false;
    }
    /**
     * Fonction qui gère l'inscription de l'utilisateur.
     * Si l'inscription est réussie, l'utilisateur est redirigé vers la page de connexion.
     * Si l'inscription échoue, un message flash est affiché.
     * Vérifie que les champs du formulaire sont remplis et valides.
     * Vérifie que les mots de passe correspondent.
     * @return bool
     */
    public function handleRegister(): bool
    {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['checkPassword'])) {
            //Creation de l'objet User avec les données du formulaire
            $user = new User("", $_POST['username'], $_POST['email'], $_POST['password'], false);
            //Création des regex
            $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d])[A-Za-z\d\S]{8,}$/';
            $usernameRegex = '/^.{4,}$/';

            if (!$user->checkUserIntegrity() || !preg_match($passwordRegex, $user->getPassword()) || !preg_match($usernameRegex, $user->getUsername())) {
                Helpers::ErrorFlash("Le formulaire est incomplet et/ou incorrect", "register");
                return false;
            }
            if ($user->checkPassword($_POST['checkPassword'])) {
                $userModel = new UserModel();
                $userModel->register($user);
                return true;
            } else {
                Helpers::ErrorFlash("Les deux mots de passe saisie sont incorrect.", "register");
                return false;
            }
        } else {
            Helpers::ErrorFlash("Le formulaire est incomplet", "register");
            return false;
        }
        return false;
    }

    /**
     * Fonction qui gère la déconnexion de l'utilisateur.
     * Détruit la session et redirige l'utilisateur vers la page d'accueil.
     */
    public function logout(): void
    {
        session_unset();
        session_destroy();
        session_start();
        Helpers::WarningFlash("Vous avez été déconnecté.", "home");
    }

    /**
     * Fonction qui affiche le formulaire de connexion.
     * Inclut la vue de connexion.
     */
    public function showLoginForm()
    {
        include_once '../Views/auth/login.php';
    }

    /**
     * Fonction qui affiche le formulaire d'inscription.
     * Inclut la vue d'inscription.
     */
    public function showRegisterForm()
    {
        include_once '../Views/auth/register.php';
    }
}
