<?php
// Headers CORS et Format
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

require_once "../functions/cours.php";
require_once "../functions/classes.php";
require_once "../functions/creneaux.php";

// Recuperer Methode GET, POST, PUT, DELETE
$methode = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$chemin = explode('/api/', $uri);
$endpoint = isset($chemin[1]) ? trim($chemin[1], '/') : '';

$data = [];
if (in_array($methode, ['POST', 'PUT', 'DELETE'])) {
    $content = file_get_contents("php://input");
    $data = json_decode($content, true) ?? [];
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
switch ($endpoint) {
    case 'classe':
        switch ($methode) {
            case 'GET':
                $data = ClasseGetAll();
                http_response_code(200);
                echo json_encode($data, JSON_PRETTY_PRINT);
                break;
            case 'POST':

                if (!isset($data["nom"]) || !isset($data["annee"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Les champs 'nom' et 'annee' sont obligatoires."
                    ]);
                    exit();
                }
                if (count(ClasseSearchBy("nom", $data['nom'])) > 0) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "La classe " . $data["nom"] . " est déjà existante."
                    ]);
                    exit();
                }
                $nom = $data["nom"];
                $annee = $data["annee"];
                if (ClasseCreate($nom, $annee) == false) {
                    http_response_code(500);
                    echo json_encode([
                        "erreur" => "serveur",
                        "message" => "Erreur interne lors de la création."
                    ]);
                    exit();
                }
                http_response_code(201);
                echo json_encode(["message" => "La classe a été ajoutée"], JSON_PRETTY_PRINT);
                break;
            case 'PUT':

                if (!isset($data["nom"]) || !isset($data["annee"]) || !isset($data["id"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Les champs 'nom', 'annee' et 'id' sont obligatoires."
                    ]);
                    exit();
                }
                if (count(ClasseSearchBy("nom", $data['nom'])) > 0) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "La classe " . $data["nom"] . " est déjà existante."
                    ]);
                    exit();
                }
                if (count(ClasseSearchBy("id", $data['id'])) <= 0) {
                    http_response_code(404);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "La classe " . $data["id"] . " n'existe pas."
                    ]);
                    exit();
                }
                $id = $data["id"];
                $nom = $data["nom"];
                $annee = $data["annee"];
                if (ClasseUpdate($id, $nom, $annee) == false) {
                    http_response_code(500);
                    echo json_encode([
                        "erreur" => "serveur",
                        "message" => "Erreur interne lors de la modification."
                    ]);
                    exit();
                }
                http_response_code(200);
                echo json_encode(["message" => "La classe a été modifiée"], JSON_PRETTY_PRINT);
                break;
            case "DELETE":

                if (!isset($data["id"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Le champ 'id' est obligatoire."
                    ]);
                    exit();
                }
                if (count(ClasseSearchBy("id", $data['id'])) <= 0) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "La classe " . $data["id"] . " n'existe pas."
                    ]);
                    exit();
                }
                $id = $data["id"];
                if (ClasseDelete($id) == false) {
                    http_response_code(500);
                    echo json_encode(
                        [
                            "erreur" => "serveur",
                            "message" => "Erreur interne lors de la suppression."
                        ]
                    );
                    exit();
                }
                http_response_code(200);
                echo json_encode(["message" => "La classe a été supprimée"], JSON_PRETTY_PRINT);
                break;
            default:
                http_response_code(404);
        }
        break;
    case "cours":
        switch ($methode) {
            case 'GET':
                $data = CoursGetAll();
                if (isset($_GET["classe"])) {
                    $horaires = CreneauxGetByClasseName($_GET["classe"]);
                    $annee = ClasseSearchAnneeByName($_GET["classe"])['annee_scolaire'];
                    $data = [
                        "classe" => $_GET["classe"],
                        "annee_scolaire" => $annee,
                        "horaires" => $horaires
                    ];
                }
                http_response_code(200);
                echo json_encode($data, JSON_PRETTY_PRINT);
                break;

            case 'POST':

                if (!isset($data["nom"]) || !isset($data["code"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Les champs 'nom' et 'code' sont obligatoires."
                    ]);
                    exit();
                }
                $nom = $data["nom"];
                $code = $data["code"];
                if (CoursCreate($nom, $code) == false) {
                    http_response_code(500);
                    echo json_encode([
                        "erreur" => "serveur",
                        "message" => "Erreur interne lors de la création."
                    ]);
                    exit();
                }
                http_response_code(201);
                echo json_encode(["message" => "Le cours a été ajouté"], JSON_PRETTY_PRINT);
                break;

            case 'PUT':

                if (!isset($data["nom"]) || !isset($data["code"]) || !isset($data["id"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Les champs 'nom', 'code' et 'id' sont obligatoires."
                    ]);
                    exit();
                }
                if (count(CoursSearchBy("id", $data['id'])) <= 0) {
                    http_response_code(404);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Le cours " . $data["id"] . " n'existe pas."
                    ]);
                    exit();
                }
                $id = $data["id"];
                $nom = $data["nom"];
                $code = $data["code"];
                if (CoursUpdate($id, $nom, $code) == false) {
                    http_response_code(500);
                    echo json_encode([
                        "erreur" => "serveur",
                        "message" => "Erreur interne lors de la modification."
                    ]);
                    exit();
                }
                http_response_code(200);
                echo json_encode(["message" => "Le cours a été modifié"], JSON_PRETTY_PRINT);
                break;

            case "DELETE":

                if (!isset($data["id"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Le champ 'id' est obligatoire."
                    ]);
                    exit();
                }
                if (count(CoursSearchBy("id", $data['id'])) <= 0) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Le cours " . $data["id"] . " n'existe pas."
                    ]);
                    exit();
                }
                $id = $data["id"];
                if (CoursDelete($id) == false) {
                    http_response_code(500);
                    echo json_encode(
                        [
                            "erreur" => "serveur",
                            "message" => "Erreur interne lors de la suppression."
                        ]
                    );
                    exit();
                }
                http_response_code(200);
                echo json_encode(["message" => "Le cours a été supprimé"], JSON_PRETTY_PRINT);
                break;

            default:
                http_response_code(404);
        }
        break;
    case "creneau":
        switch ($methode) {
            case 'GET':
                $data = CreneauxGetAll();
                http_response_code(200);
                echo json_encode($data, JSON_PRETTY_PRINT);
                break;

            case 'POST':

                if (!isset($data["classe"]) || !isset($data["cours"]) || !isset($data["jour"]) || !isset($data["debut"]) || !isset($data["fin"]) || !isset($data["salle"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Les champs 'classe', 'cours','jour', 'debut','fin' et 'salle' sont obligatoires."
                    ]);
                    exit();
                }
                $classeId = $data["classe"];
                $coursId = $data["cours"];
                $jour = $data["jour"];
                $debut = $data["debut"];
                $fin = $data["fin"];
                $salle = $data["salle"];
                if (CreneauxCreate($classeId, $coursId, $jour, $debut, $fin, $salle) == false) {
                    http_response_code(500);
                    echo json_encode([
                        "erreur" => "serveur",
                        "message" => "Erreur interne lors de la création."
                    ]);
                    exit();
                }
                http_response_code(201);
                echo json_encode(["message" => "Le créneau a été ajouté"], JSON_PRETTY_PRINT);
                break;

            case 'PUT':

                if (!isset($data['id']) || !isset($data["classe"]) || !isset($data["cours"]) || !isset($data["jour"]) || !isset($data["debut"]) || !isset($data["fin"]) || !isset($data["salle"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Les champs 'classe', 'cours','jour', 'debut','fin' et 'salle' sont obligatoires."
                    ]);
                    exit();
                }
                if (count(CreneauxSearchBy("id", $data['id'])) <= 0) {
                    http_response_code(404);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Le créneau " . $data["id"] . " n'existe pas."
                    ]);
                    exit();
                }
                $id = $data["id"];
                $classeId = $data["classe"];
                $coursId = $data["cours"];
                $jour = $data["jour"];
                $debut = $data["debut"];
                $fin = $data["fin"];
                $salle = $data["salle"];
                if (CreneauxUpdate($id, $classeId, $coursId, $jour, $debut, $fin, $salle) == false) {
                    http_response_code(500);
                    echo json_encode([
                        "erreur" => "serveur",
                        "message" => "Erreur interne lors de la modification."
                    ]);
                    exit();
                }
                http_response_code(200);
                echo json_encode(["message" => "Le créneau a été modifié"], JSON_PRETTY_PRINT);
                break;

            case "DELETE":

                if (!isset($data["id"])) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Le champ 'id' est obligatoire."
                    ]);
                    exit();
                }
                if (count(CreneauxSearchBy("id", $data['id'])) <= 0) {
                    http_response_code(400);
                    echo json_encode([
                        "erreur" => "champs",
                        "message" => "Le créneau " . $data["id"] . " n'existe pas."
                    ]);
                    exit();
                }
                $id = $data["id"];
                if (CreneauxDelete($id) == false) {
                    http_response_code(500);
                    echo json_encode(
                        [
                            "erreur" => "serveur",
                            "message" => "Erreur interne lors de la suppression."
                        ]
                    );
                    exit();
                }
                http_response_code(200);
                echo json_encode(["message" => "Le créneau a été supprimé"], JSON_PRETTY_PRINT);
                break;

            default:
                http_response_code(404);
        }
        break;
    default:
        http_response_code(404);
        break;
}