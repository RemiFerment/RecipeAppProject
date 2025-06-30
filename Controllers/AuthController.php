<?php
require_once "../config/database.php";
require_once "../config/helpers.php";
class AuthController
{

    public function login(string $email, string $password): bool
    {
        $pdo = Database::getConnection();
        if ($pdo !== null) {
            $request = "SELECT * FROM user WHERE email = :email";
            $statement = $pdo->prepare($request);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            if ($statement->execute()) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) === 1 && password_verify($password, $result[0]['password'])) {
                    $userInformation = $result[0];
                    $_SESSION['UUID'] = $userInformation['UUID'];
                    $_SESSION['pseudo'] = $userInformation['pseudo'];
                    Helpers::setFlash("Connexion réussi !", "success");
                    header("Location: ?page=home");
                    exit;
                    return true;
                } else {
                    return false;
                }
            };
        } else {
            Helpers::setFlash("Impossible de communiquer avec la base de données, contacter l'administrateur", "error");
            return false;
        }
        return false;
    }
    public function register(string $email, string $password, string $username): bool
    {
        $pdo = Database::getConnection();
        if ($pdo !== null) {
            $request = "SELECT * FROM user WHERE email = :email";
            $statement = $pdo->prepare($request);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            if ($statement->execute()) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) === 1) {
                    //On retourne false car on souhaite que l'adresse mail soit unique.
                    Helpers::setFlash("L'adresse mail est déjà utilisée.", "warning");
                    return false;
                } else  if (count($result) === 0) {
                    //Il n'y a pas la même adresse mail, donc on peut insérer les données dans la base de donnée
                    $registerRequest = "INSERT INTO user (UUID,pseudo,email,password,created_at) VALUES(UUID(),:pseudo,:email,:password,NOW())";
                    $registerStmt = $pdo->prepare($registerRequest);
                    $registerStmt->bindValue(':pseudo', $username);
                    $registerStmt->bindValue(':email', $email);
                    $registerStmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
                    if ($registerStmt->execute()) {
                        Helpers::setFlash("L'inscription a réussi !", "success");
                        header("Location: ?page=login");
                        exit;
                        return true;
                    }
                }
            }
        } else {
            Helpers::setFlash("Impossible de communiquer avec la base de données, contacter l'administrateur", "error");
        }
        return false;
    }
    public function handleLogin()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if ($this->login($_POST['email'], $_POST['password'])) {
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

            $email = $_POST['email'];
            $password = $_POST['password'];
            $username = $_POST['username'];
            $checkPassword = $_POST['checkPassword'];

            $checkFormIntegrity = empty($email) || empty($password) || empty($checkPassword) || empty($username);
            if ($checkFormIntegrity) {
                Helpers::setFlash("Le formulaire est incomplet", "error");
                return;
            }
            if ($checkPassword === $password) {
                $this->register(trim($email), trim($password), trim($username));
                return;
            } else {
                echo '<span style="color: red;">Les champs des mots de passe ne correspondent pas.';
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
