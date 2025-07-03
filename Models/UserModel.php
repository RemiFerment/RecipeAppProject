<?php
require_once "../Models/Entities/User.php";
class UserModel
{

    // public function register(string $email, string $password, string $username): bool
    // {
    //     $pdo = Database::getConnection();
    //     if ($pdo !== null) {
    //         $request = "SELECT * FROM user WHERE email = :email";
    //         $statement = $pdo->prepare($request);
    //         $statement->bindValue(":email", $email, PDO::PARAM_STR);
    //         if ($statement->execute()) {
    //             $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    //             if (count($result) === 1) {
    //                 //On retourne false car on souhaite que l'adresse mail soit unique.
    //                 Helpers::setFlash("L'adresse mail est déjà utilisée.", "warning");
    //                 return false;
    //             } else  if (count($result) === 0) {
    //                 //Il n'y a pas la même adresse mail, donc on peut insérer les données dans la base de donnée
    //                 $registerRequest = "INSERT INTO user (UUID,pseudo,email,password,created_at) VALUES(UUID(),:pseudo,:email,:password,NOW())";
    //                 $registerStmt = $pdo->prepare($registerRequest);
    //                 $registerStmt->bindValue(':pseudo', $username);
    //                 $registerStmt->bindValue(':email', $email);
    //                 $registerStmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
    //                 if ($registerStmt->execute()) {
    //                     Helpers::setFlash("L'inscription a réussi !", "success");
    //                     header("Location: ?page=login");
    //                     exit;
    //                     return true;
    //                 }
    //             }
    //         }
    //     } else {
    //         Helpers::setFlash("Impossible de communiquer avec la base de données, contacter l'administrateur", "error");
    //     }
    //     return false;
    // }
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
            Helpers::setFlash("Impossible de communiquer avec la base de données, contacter l'administrateur", "error");
        }
        return false;
    }
}
