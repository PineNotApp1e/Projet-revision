<?php
session_start();
include "../includes/header.php";
require_once "../functions/creneaux.php";
require_once "../functions/cours.php";
require_once "../functions/classes.php";
$classes = ClasseGetAll();
$cours = CoursGetAll();
echo Menu("horaire");
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["ajout"])) {
        if (!CreneauxCreate($_POST["classe"], $_POST["cours"], $_POST["jours"], $_POST["debut"], $_POST["fin"], $_POST["salle"])) {
            $_SESSION['message'] = '<div class="alert alert-success mt-2" role="alert" ><h4 class="alert-heading">Le créneau a été ajouté avec succès !</h4></div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger mt-2" role="alert" ><h4 class="alert-heading">Erreur pendant la création du créneau</h4></div>';
        }
    } else if (isset($_POST["Modifier"])) {
        if (!CreneauxUpdate($_POST["Modifier"], $_POST["classe"], $_POST["cours"], $_POST["jours"], $_POST["debut"], $_POST["fin"], $_POST["salle"])) {
            $_SESSION['message'] = '<div class="alert alert-success mt-2" role="alert" ><h4 class="alert-heading">Le créneau a été modifié avec succès !</h4></div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger mt-2" role="alert" ><h4 class="alert-heading">Erreur lors de la modification du créneau</h4></div>';
        }
    } else if (isset($_POST["Supprimer"])) {
        if (!CreneauxDelete($_POST["Supprimer"])) {
            $_SESSION['message'] = '<div class="alert alert-success mt-2" role="alert" ><h4 class="alert-heading">Le créneau a été supprimé avec succès !</h4></div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger mt-2" role="alert" ><h4 class="alert-heading">Erreur lors de la suppression du créneau</h4></div>';
        }
    }
    header('Location: horaire.php');
    exit;
}
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet horaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <?php
    if (count($classes) <= 0 || count($cours) <= 0) {
        echo '<div class="alert alert-primary position-absolute top-50 start-50 translate-middle" role="alert" style="width: 500px;">Créez une classe et un cours avant de faire un horaire</div>';
    } else {
        ?>
        <form action="horaire.php" method="post" class="  pt-5 mt-5  mx-auto p-2 " style="width: 500px;">
            <div class="mb-3">
                <label for="classe" class="form-label">Nom de la classe :</label>
                <select class="form-select" name="classe">
                    <?php
                    foreach ($classes as $key => $value) {
                        echo "<option " . ($key == 0 ? 'selected' : '') . "  value='" . $value['id'] . "'>" . htmlspecialchars($value['nom']) . "</option>";

                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="cours" class="form-label">Nom du cours :</label>
                <select class="form-select" name="cours">
                    <?php
                    foreach ($cours as $key => $value) {
                        echo "<option " . ($key == 0 ? 'selected' : '') . "  value='" . $value['id'] . "'>" . htmlspecialchars($value['nom']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jours" class="form-label">Jour du cours :</label>
                <select class="form-select" name="jours">
                    <option selected value='Lundi'>Lundi</option>
                    <option value='Mardi'>Mardi</option>
                    <option value='Mercredi'>Mercredi</option>
                    <option value='Jeudi'>Jeudi</option>
                    <option value='Vendredi'>Vendredi</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="salle" class="form-label">Salle du cours :</label>
                <input type="text" name="salle" class="form-control">
            </div>
            <div class="mb-3">
                <label for="debut" class="form-label">Heure du début :</label>
                <input type="time" class="form-control" name="debut" value="08:05">
            </div>
            <div class="mb-3">
                <label for="fin" class="form-label">Heure de fin :</label>
                <input type="time" class="form-control" name="fin" value="11:40">
            </div>
            <button type="submit" name="ajout" class="btn btn-primary">Créer l'horaire</button>
            <?php
            echo $message;
            ?>
        </form>
        <h2 class="pt-5 mx-auto p-2" style="width: 500px;">Liste des horaires</h2>

        <div class="list-group mx-auto p-2" style="width: 500px;">
            <?php
            $creneaux = CreneauxGetAll();
            foreach ($creneaux as $creneau) {
                echo "<button type='button' class='list-group-item list-group-item-action justify-content-center' data-bs-toggle='modal' data-bs-target='#Creneaux{$creneau['id']}'><b>" . htmlspecialchars($creneau['classe']) . " : </b>" . htmlspecialchars($creneau['cours']) . " de " . htmlspecialchars($creneau['heure_debut']) . " à " . htmlspecialchars($creneau['heure_fin']) . " le " . htmlspecialchars($creneau['jour']) . " en salle " . htmlspecialchars($creneau['salle']) . "</button>";
            }
            ?>
        </div>
        <?php
        foreach ($creneaux as $creneau) {
            echo "<div class='modal fade' id='Creneaux{$creneau['id']}' data-bs-keyboard='false' tabindex='-1'
        aria-labelledby='staticBackdropLabel' aria-hidden='true' >
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='staticBackdropLabel'>Modification</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <form action='horaire.php' method='post'>
                    <div class='modal-body'>
                        <div class='mb-3'>
                            <label for='classe' class='form-label'>Nom de la classe :</label>
                            <select class='form-select' name='classe' >";
            foreach ($classes as $value) {
                echo "<option " . ($creneau['classe_id'] == $value['id'] ? 'selected' : '') . "  value='" . $value['id'] . "'>" . htmlspecialchars($value['nom']) . "</option>";
            }
            echo "</select>
                        </div>
                        <div class='mb-3'>
                            <label for='cours' class='form-label'>Nom du cours :</label>
                            <select class='form-select' name='cours'> ";
            foreach ($cours as $value) {
                echo "<option " . ($creneau['cours_id'] == $value['id'] ? 'selected' : '') . "  value='" . $value['id'] . "'>" . htmlspecialchars($value['nom']) . "</option>";
            }
            echo "</select>
                        </div>
                        <div class='mb-3'>
                            <label for='jours' class='form-label'>Jour du cours :</label>
                            <select class='form-select' name='jours'>";
            foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'] as $j) {
                echo "<option value='$j' " . ($creneau['jour'] === $j ? 'selected' : '') . ">$j</option>";
            }
            echo "</select>
                        </div>
                        <div class='mb-3'>
                            <label for='salle' class='form-label'>Salle du cours :</label>
                            <input type='text' name='salle' class='form-control' value='" . htmlspecialchars($creneau['salle']) . "'>
                        </div>
                        <div class='mb-3'>
                            <label for='debut' class='form-label'>Heure du début :</label>
                            <input type='time' class='form-control' name='debut' value='" . htmlspecialchars($creneau['heure_debut']) . "'>
                        </div>
                        <div class='mb-3'>
                            <label for='fin' class='form-label'>Heure de fin :</label>
                            <input type='time' class='form-control' name='fin' value='" . htmlspecialchars($creneau['heure_fin']) . "'>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' name='Supprimer' value='" . htmlspecialchars($creneau['id']) . "' class='btn btn-danger' data-bs-dismiss='modal'>Supprimer</button>
                        <button type='submit' name='Modifier' value='" . htmlspecialchars($creneau['id']) . "' class='btn btn-success'>Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>";
        }
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

</html>