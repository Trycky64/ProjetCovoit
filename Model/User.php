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

    public static function createUser($pdo, $user)
    {
        $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        return $stmt->execute([$user->email, $user->password]);
    }

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

    public static function getUserById($pdo, $userId)
    {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateUser($pdo, $user)
    {
        $stmt = $pdo->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
        return $stmt->execute([$user->email, $user->password, $user->id]);
    }

    public static function getPreferredDrivers(PDO $pdo, int $userId): array {
        $stmt = $pdo->prepare("
            SELECT u.*
            FROM users u
            JOIN preferred_drivers pd ON u.id = pd.driver_id
            WHERE pd.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}