<?php
class User
{
    private $id;
    private $email;
    private $password;

    public function __construct($id, $email, $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    // Créer un nouvel utilisateur
    public static function createUser($pdo, $user)
    {
        $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        return $stmt->execute([$user->email, $user->password]);
    }

    // Authentifier un utilisateur
    public static function authenticate($pdo, $email, $password)
    {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Récupérer un utilisateur par ID
    public static function getUserById($pdo, $userId)
    {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les informations utilisateur
    public static function updateUser($pdo, $user)
    {
        $stmt = $pdo->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
        return $stmt->execute([$user->email, $user->password, $user->id]);
    }
}
