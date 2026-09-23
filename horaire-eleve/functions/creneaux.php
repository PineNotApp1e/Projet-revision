<?php
require_once __DIR__ . '/../connexion/db.php';

function CreneauxCreate($classeId, $coursId, $jour, $debut, $fin, $salle)
{
    $pdo = DbPdo();
    $erreur = false;
    $semaine = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi');
    if (!in_array($jour, $semaine)) {
        return true;
    }
    try {

        $sql = "INSERT INTO creneaux (classe_id,cours_id,jour,heure_debut,heure_fin,salle) VALUES (?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$classeId, $coursId, $jour, $debut, $fin, $salle]);
    } catch (PDOException $e) {
        $erreur = true;
    }
    return $erreur;
}
function CreneauxGetAll(): array
{
    $pdo = DbPdo();

    try {
        $sql =
            "SELECT cl.nom as classe, co.nom as cours, h.classe_id, h.cours_id,h.id,h.jour,h.heure_debut,h.heure_fin,h.salle
            FROM creneaux h
            INNER JOIN cours co
                ON h.cours_id = co.id
            INNER JOIN classes cl
                ON h.classe_id = cl.id 
            ORDER BY 
                cl.nom ASC,
                FIELD(h.jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'),
                h.heure_debut ASC
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function CreneauxGetByClasse($id): array
{
    $pdo = DbPdo();

    try {
        $sql =
            "SELECT cl.nom as classe, co.code as cours, h.id, h.jour, h.heure_debut, h.heure_fin, h.salle
            FROM creneaux h
            INNER JOIN cours co
                ON h.cours_id = co.id
            INNER JOIN classes cl
                ON h.classe_id = cl.id 
            WHERE cl.id LIKE ?
            ORDER BY 
                FIELD(h.jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'), 
                h.heure_debut ASC           
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
function CreneauxGetByClasseName($nom): array
{
    $pdo = DbPdo();

    try {
        $sql =
            "SELECT co.code as code_cours, co.nom as cours, h.id, h.jour, h.heure_debut, h.heure_fin, h.salle
            FROM creneaux h
            INNER JOIN cours co
                ON h.cours_id = co.id
            INNER JOIN classes cl
                ON h.classe_id = cl.id 
            WHERE cl.nom LIKE ?
            ORDER BY 
                FIELD(h.jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'), 
                h.heure_debut ASC           
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function CreneauxGetByCours($id): array
{
    $pdo = DbPdo();

    try {
        $sql =
            "SELECT cl.nom as classe, co.code as cours, h.id,h.jour,h.heure_debut,h.heure_fin,h.salle
            FROM creneaux h
            INNER JOIN cours co
                ON h.cours_id = co.id
            INNER JOIN classes cl
                ON h.classe_id = cl.id 
            WHERE co.id LIKE ?
            ORDER BY                
                FIELD(h.jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'), 
                cl.nom ASC,
                h.heure_debut ASC          
            ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function CreneauxDelete($id): bool
{
    $pdo = DbPdo();
    $erreur = false;

    try {
        $sql = "DELETE FROM creneaux WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);


    } catch (PDOException $e) {
        $erreur = true;
    }
    return $erreur;
}
function CreneauxUpdate($id, $classeId, $coursId, $jour, $debut, $fin, $salle): bool
{
    $pdo = DbPdo();
    $erreur = false;
    $semaine = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi');
    if (!in_array($jour, $semaine)) {
        return true;
    }
    try {
        $sql = "UPDATE creneaux SET classe_id = ?, cours_id = ?, jour = ?, heure_debut = ?, heure_fin = ?, salle = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([$classeId, $coursId, $jour, $debut, $fin, $salle, $id]);
    } catch (PDOException $e) {
        $erreur = true;
    }
    return $erreur;
}
function CreneauxSearchBy($attribut, $recherche): array
{
    $pdo = DbPdo();

    $sql = "SELECT * FROM creneaux WHERE $attribut LIKE ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$recherche]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}