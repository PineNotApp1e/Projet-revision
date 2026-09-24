<?php
require_once __DIR__ . '/../connexion/db.php';
function ClasseCreate($name, $annee)
{
    $pdo = DbPdo();
    $erreur = false;
    try {
        $sql = "INSERT INTO classes (nom,annee_scolaire) VALUES (?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $annee]);


    } catch (PDOException $e) {
        $erreur = true;
    }
    return $erreur;
}
function ClasseGetAll(): array
{
    $pdo = DbPdo();

    $sql = "SELECT * FROM classes";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}
function ClasseSearchBy($attribut, $recherche): array
{
    $pdo = DbPdo();

    $sql = "SELECT * FROM classes WHERE $attribut LIKE ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$recherche]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function ClasseSearchAnneeByName($recherche): array
{
    $pdo = DbPdo();

    $sql = "SELECT annee_scolaire FROM classes WHERE nom LIKE ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$recherche]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function ClasseUpdate($id, $nom, $annee): bool
{
    $pdo = DbPdo();
    $erreur = false;

    try {
        $sql = "UPDATE classes SET nom = ?, annee_scolaire = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([$nom, $annee, $id]);
    } catch (PDOException $e) {
        $erreur = true;
    }
    return $erreur;
}
function ClasseDelete($id): bool
{
    $pdo = DbPdo();
    $erreur = false;


    try {
        $sql = "DELETE FROM classes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    } catch (PDOException $e) {
                $erreur = true;
    }
    return $erreur;
}