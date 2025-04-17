<?php

function getPDO()
{
    static $pdo = null;

    if ($pdo === null) {
        $host = 'localhost'; // The service name defined in docker-compose.yml
        $db = 'covoiturage'; // Database name
        $user = 'root'; // Default root user for MySQL
        $pass = ''; // Password defined in docker-compose.yml
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    return $pdo;
}
