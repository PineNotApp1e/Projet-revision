<?php

require_once __DIR__ . '/../connexion/db.php';

function CoursCreate($name, $code)
{
    $pdo = DbPdo();
    $erreur = false;
    try {
        $sql = "INSERT INTO cours (nom,code) VALUES (?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $code]);


    } catch (PDOException $e) {
        $erreur = true;
    }
    return $erreur;
}
function CoursGetAll(): array
{
    $pdo = DbPdo();
    try {
        $sql = "SELECT * FROM cours";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
function CoursSearchBy($attribut, $recherche): array
{
    $pdo = DbPdo();

    $sql = "SELECT * FROM cours WHERE $attribut LIKE ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['%' . $recherche . '%']);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function CoursUpdate($id, $nom, $code): bool
{
    $pdo = DbPdo();
    $erreur = false;
    try {
        $sql = "UPDATE cours SET nom = ?, code = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([$nom, $code, $id]);


    } catch (PDOException $e) {
        $erreur = true;
    }
    return $erreur;
}
function CoursDelete($id): bool
{
    $pdo = DbPdo();
    $erreur = false;

    try {
        $sql = "DELETE FROM cours WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

    } catch (PDOException $e) {
        $erreur = true;
    }
    return $erreur;
}