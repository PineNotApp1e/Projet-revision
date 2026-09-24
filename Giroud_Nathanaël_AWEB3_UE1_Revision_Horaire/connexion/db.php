<?php

require_once __dir__."/../config/database.php";
function DbPdo(): PDO
{
    $host = DB_HOST;
    $dbname = DB_NAME;
    $username = DB_USER;
    $password = DB_PASS;
    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    } catch (PDOException $e) {

        die("Erreur de connexion à la base de données : ");
    }
}
?>