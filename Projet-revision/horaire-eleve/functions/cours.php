<?php

require_once __DIR__ . '/../connexion/db.php';

function CoursCreate($name, $code)
{
    $pdo = DbPdo();
    $message = "";
    try {
        $sql = "INSERT INTO cours (nom,code) VALUES (?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $code]);

        $message = 'Le cours a été ajoutée avec succès !';

    } catch (PDOException $e) {
        $message = 'Erreur : Impossible d\'ajouter ce cours. ' . $e->getMessage();

    }
    return $message;
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
function CoursearchBy($attribut, $recherche): array
{
    $pdo = DbPdo();

    $sql = "SELECT * FROM cours WHERE $attribut LIKE ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['%' . $recherche . '%']);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function CoursUpdate($id, $nom, $annee): string
{
    $pdo = DbPdo();
    $message = "";
    try {
        $sql = "UPDATE cours SET nom = ?, code = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([$nom, $annee, $id]);
        $message = 'Le cours a été modifiée avec succès !';

    } catch (PDOException $e) {
        $message = 'Erreur : Impossible de modifier ce cours. ' . $e->getMessage();
    }
    return $message;
}
function CoursDelete($id): string
{
    $pdo = DbPdo();
    $message = "";

    try {
        $sql = "DELETE FROM cours WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $message = 'Le cours a été supprimée avec succès !';

    } catch (PDOException $e) {
        $message = "Impossible de supprimer ce cours car elle contient des horaires.";
    }
    return $message;
}