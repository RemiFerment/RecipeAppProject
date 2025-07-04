<?php
class User
{
    private string $UUID;
    private string $username;
    private string $email;
    private string $password;
    private string $hashedPassword;

    public function __construct($UUID, string $username, string $email, string $password, bool $ishashedPswd = true)
    {
        $this->UUID = $UUID;
        $this->username = $username;
        $this->email = $email;
        if ($ishashedPswd) {
            $this->hashedPassword = $password;
            $this->password = "";
        } else {
            $this->password = $password;
            $this->hashedPassword = "";
        }
    }

    public function getUUID(): string
    {
        return $this->UUID;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }


    public function setUUID(string $newUUID): void
    {
        $this->UUID = $newUUID;
    }
    public function setUsername(string $newUsername): string
    {
        return $this->username = $newUsername;
    }
    public function setEmail(string $newEmail): string
    {
        return $this->email = $newEmail;
    }
    public function setPassword(string $newPassword): string
    {
        return $this->password = $newPassword;
    }
    public function sethashedPassword(string $newhashedPassword): void
    {
        $this->hashedPassword = $newhashedPassword;
    }

    /**
     * Vérifie si l'objet User a intégralement récupéré les données du formulaire
     * @return bool Retourne faux quand l'une des données est vide ou null.
     */
    public function checkUserIntegrity(): bool
    {
        return !empty($this->username) && !empty($this->email) && !empty($this->password);
    }

    /**
     * Permet de comparer le mot de passe de l'objet User avec un autre.
     * 
     * ATTENTION, NE FONCTIONNE QUE SUR LES MOTS DE PASSE EN DUR.
     * @param string $passwordToCheck Le mot de passe à vérifier.
     * @return bool Retourne vrai si les mots de passe correspondent.
     */
    public function checkPassword(string $passwordToCheck): bool
    {
        return $this->password === $passwordToCheck;
    }

    // public static function getUserByLogin(string $newUUID, string $newUsername, string $newEmail, string $newhashedPassword): User
    // {
    //     $user =  new User($newUUID, $newUsername, $newEmail, $newHashedPassword);
    //     return $user;
    // }
}
