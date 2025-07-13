<?php
require_once "../Models/Entities/User.php";
require_once "../config/database.php";
class UserModel
{
    /**
     * Fonction qui gère l'inscription de l'utilisateur.
     * Elle prend en paramètre un objet User et insère les données dans la base de données.
     * 
     * Si l'adresse email est déjà utilisée, elle affiche un message d'avertissement.
     * 
     * Si l'insertion réussit, elle affiche un message de succès et retourne true.
     * 
     * Si l'insertion échoue, elle affiche un message d'erreur et retourne false.
     * @param User $user
     * @return bool
     */
    public function register(User $user): bool
    {
        $pdo = Database::getConnection();
        if ($pdo !== null) {
            $request = "SELECT * FROM user WHERE email = :email";
            $statement = $pdo->prepare($request);
            $statement->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            try {
                if ($statement->execute()) {
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    if (count($result) === 1) {
                        //On retourne false car on souhaite que l'adresse mail soit unique.
                        Helpers::WarningFlash("L'adresse mail est déjà utilisée.", "register");
                        return false;
                    } else  if (count($result) === 0) {
                        //Il n'y a pas la même adresse mail, donc on peut insérer les données dans la base de donnée
                        $registerRequest = "INSERT INTO user (UUID,pseudo,email,password,created_at) VALUES(UUID(),:pseudo,:email,:password,NOW())";
                        $registerStmt = $pdo->prepare($registerRequest);
                        $registerStmt->bindValue(':pseudo', $user->getUsername());
                        $registerStmt->bindValue(':email', $user->getEmail());
                        $registerStmt->bindValue(':password', password_hash($user->getPassword(), PASSWORD_BCRYPT));
                        if ($registerStmt->execute()) {
                            Helpers::SuccessFlash("L'inscription a réussi !", "login");
                            return true;
                        }
                    }
                }
            } catch (Error $e) {
                $eMsg = $e->getMessage();
                throw new Error("$eMsg");
            }
        } else {
            Helpers::ErrorFlash("Impossible de communiquer avec la base de données, contacter l'administrateur", "register");
        }
        return false;
    }

    /**
     * Fonction qui gère la connexion de l'utilisateur.
     * Elle prend en paramètres l'email et le mot de passe de l'utilisateur.
     * 
     * Si l'email et le mot de passe sont corrects, elle initialise la session et affiche un message de succès.
     * 
     * Si l'email ou le mot de passe est incorrect, elle affiche un message d'erreur.
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        $user = $this->findByEmail($email);
        if ($user !== null) {
            if (password_verify($password, $user->getHashedPassword())) {
                $_SESSION['UUID'] = $user->getUUID();
                $_SESSION['username'] = $user->getUsername();
                Helpers::SuccessFlash("Connexion réussi !", "home");
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Fonction qui trouve un utilisateur par son adresse email.
     * Elle retourne un objet User si l'utilisateur est trouvé, ou null si l'utilisateur n'existe pas.
     * @param string $email
     * @return User|null 
     */
    public function findByEmail(string $email): ?User
    {
        $pdo = Database::getConnection();
        if ($pdo !== null) {
            $request = "SELECT UUID,pseudo AS 'username',email,password AS 'hashedPassword'  FROM user WHERE email = :email";
            $statement = $pdo->prepare($request);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            try {
                if ($statement->execute()) {
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    if ($result['UUID'] !== null) {
                        $user = new User($result['UUID'], $result['username'], $result['email'], $result['hashedPassword']);
                        return $user;
                    } else {
                        return null;
                    }
                } else {
                    Helpers::ErrorFlash("Une erreur inatendue est survenue.", "login");
                    return null;
                }
            } catch (ErrorException $e) {
                throw new ErrorException($e->getMessage());
            }
        }
        Helpers::ErrorFlash("Impossible de communiquer avec la base de données, contacter l'administrateur", "login");
        return null;
    }
}
