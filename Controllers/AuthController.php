<?php
require_once "../config/database.php";
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
                    echo "<h2>Bonjour " . $result[0]['pseudo'] . "</h2>";
                    return true;
                } else {
                    echo "<h3>Login ou mot de passe incorrect </h3>";
                    return false;
                }
            };
        } else {
            echo "<h3>Impossible de communiquer avec la base de donnée, contactez l'administrateur.</h3>";
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
                    echo "<h3>L'adresse mail est déjà utilisée...</h3>";
                    return false;
                } else  if (count($result) === 0) {
                    //Il n'y a pas la même adresse mail, donc on peut insérer les données dans la base de donnée
                    $registerRequest = "INSERT INTO user (UUID,pseudo,email,password,created_at) VALUES(UUID(),:pseudo,:email,:password,NOW())";
                    $registerStmt = $pdo->prepare($registerRequest);
                    $registerStmt->bindValue(':pseudo', $username);
                    $registerStmt->bindValue(':email', $email);
                    $registerStmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
                    if ($registerStmt->execute()) {
                        echo "<h3>L'inscription est réussi ! :D</h3>";
                        return true;
                    }
                }
            }
        } else {
            echo "<h3>Impossible de communiquer avec la base de donnée, contactez l'administrateur.</h3>";
        }
        return false;
    }
    public function handleLogin()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if($this->login($_POST['email'], $_POST['password'])){
                
            }
        }
    }
    public function handleRegister()
    {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['checkPassword'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];
            $username = $_POST['username'];
            $checkPassword = $_POST['checkPassword'];

            $checkFormIntegrity = empty($email) || empty($password) || empty($checkPassword) || empty($username);
            if ($checkFormIntegrity) {
                echo "Le formulaire est incomplet";
                die;
            }
            if ($checkPassword === $password) {
                $this->register(trim($email), trim($password), trim($username));
            } else {
                echo '<span style="color: red;">Les champs des mots de passe ne correspondent pas.';
            }
        } else {
            echo "Le formulaire est incomplet";
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
}
