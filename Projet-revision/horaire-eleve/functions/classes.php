<?php
require_once __DIR__ . '/../connexion/db.php';
function ClasseCreate($name, $annee)
{
    $pdo = DbPdo();
    $message="";
    try {
        $sql = "INSERT INTO classes (nom,annee_scolaire) VALUES (?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $annee]);

        $message = 'La classe a été ajoutée avec succès !';

    } catch (PDOException $e) {
        $message = 'Erreur : Impossible d\'ajouter cette classe. ' . $e->getMessage();

    }
    return $message;
}
function ClasseGetAll() : array {
    $pdo = DbPdo(); 
    
    $sql = "SELECT * FROM classes";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function ClasseSearchBy($attribut,$recherche) : array {
    $pdo = DbPdo();
    
    $sql = "SELECT * FROM classes WHERE $attribut LIKE ?";

    $stmt = $pdo->prepare($sql);
    
    $stmt->execute(['%' . $recherche . '%']);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function ClasseUpdate($id, $nom, $annee) : string {
    $pdo = DbPdo();
    $message="";
    try {
        $sql = "UPDATE classes SET nom = ?, annee_scolaire = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([$nom, $annee, $id]); 
        $message = 'La classe a été modifiée avec succès !';
        
    } catch (PDOException $e) {
        $message = 'Erreur : Impossible de modifier cette classe. ' . $e->getMessage();
    }
    return $message;
}
function ClasseDelete($id) : string {
    $pdo = DbPdo();
    $message="";

    try {
        $sql = "DELETE FROM classes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $message = 'La classe a été supprimée avec succès !';
        
    } catch (PDOException $e) {
        $message = "Impossible de supprimer cette classe car elle contient des horaires.";
    }
    return $message;
}