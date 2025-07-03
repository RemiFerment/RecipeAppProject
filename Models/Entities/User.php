<?php
class User
{
    private string $UUID;
    private string $username;
    private string $email;
    private string $password;

    public function __construct($UUID, $username, $email, $password)
    {
        $this->UUID = $UUID;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
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
}
