<?php


function DbPdo(): PDO
{
    $host = 'localhost';
    $dbname = 'horaire';
    $username = 'nathanaelgrd';
    $password = '12awdrg';
    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    } catch (PDOException $e) {

        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>