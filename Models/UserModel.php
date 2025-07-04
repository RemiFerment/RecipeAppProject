<?php
require_once "../Models/Entities/User.php";
require_once "../config/database.php";
class UserModel
{
    public function register(User $user): bool
    {
        $pdo = Database::getConnection();
        if ($pdo !== null) {
            $request = "SELECT * FROM user WHERE email = :email";
            $statement = $pdo->prepare($request);
            $statement->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            if ($statement->execute()) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) === 1) {
                    //On retourne false car on souhaite que l'adresse mail soit unique.
                    Helpers::setFlash("L'adresse mail est déjà utilisée.", "warning");
                    header("Location: ?page=register");
                    exit;
                    return false;
                } else  if (count($result) === 0) {
                    //Il n'y a pas la même adresse mail, donc on peut insérer les données dans la base de donnée
                    $registerRequest = "INSERT INTO user (UUID,pseudo,email,password,created_at) VALUES(UUID(),:pseudo,:email,:password,NOW())";
                    $registerStmt = $pdo->prepare($registerRequest);
                    $registerStmt->bindValue(':pseudo', $user->getUsername());
                    $registerStmt->bindValue(':email', $user->getEmail());
                    $registerStmt->bindValue(':password', password_hash($user->getPassword(), PASSWORD_BCRYPT));
                    if ($registerStmt->execute()) {
                        Helpers::setFlash("L'inscription a réussi !", "success");
                        header("Location: ?page=login");
                        exit;
                        return true;
                    }
                }
            }
        } else {
            Helpers::setFlash("Impossible de communiquer avec la base de données, contacter l'administrateur", "danger");
        }
        return false;
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->findByEmail($email);
        if ($user !== null) {
            if (password_verify($password, $user->getHashedPassword())) {
                $_SESSION['UUID'] = $user->getUUID();
                $_SESSION['username'] = $user->getUsername();
                Helpers::setFlash("Connexion réussi !", "success");
                header("Location: ?page=home");
                exit;
                return true;
            }
            return false;
        }
        return false;
    }

    public function findByEmail(string $email): ?User
    {
        $pdo = Database::getConnection();
        if ($pdo !== null) {
            $request = "SELECT UUID,pseudo AS 'username',email,password AS 'hashedPassword'  FROM user WHERE email = :email";
            $statement = $pdo->prepare($request);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            if ($statement->execute()) {
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                if ($result['UUID'] !== null) {
                    $user = new User($result['UUID'], $result['username'], $result['email'], $result['hashedPassword']);
                    return $user;
                } else {
                    return null;
                }
            } else {
                Helpers::setFlash("Une erreur inatendue est survenue.", "danger");
                header("Location: ?page=login");
                exit;
                return null;
            }
        }
        Helpers::setFlash("Impossible de communiquer avec la base de données, contacter l'administrateur", "danger");
        header("Location: ?page=login");
        exit;
        return null;
    }
}
