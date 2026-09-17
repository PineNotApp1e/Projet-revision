<?php
include "../includes/header.php";
require_once "../functions/creneaux.php";
require_once "../functions/cours.php";
require_once "../functions/classes.php";
$classes = ClasseGetAll();
$cours = CoursGetAll();

echo Menu("horaire");
$message = "";
// if (isset($_POST["ajout"])) {
//     $message = CoursCreate($_POST["nom"], $_POST["code"]);
// } else if (isset($_POST["Modifier"])) {
//     $message = CoursUpdate($_POST["Modifier"], $_POST["nom"], $_POST["code"]);
// } else if (isset($_POST["Suprimer"])) {
//     $message = CoursDelete($_POST["Suprimer"]);
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet hoiraire</title>
</head>

<body>
    <?php
    if (count($classes) <= 0 || count($cours) <= 0) {
        echo '<div class=" bg-primary border border-primary position-absolute top-50 start-50 translate-middle fs-3"  style="width: 500px;>Créer une classe et un cour avant de faire un horaire</div>';
    } else {
        ?>
        <form action="cours.php" method="post" class=" mx-auto p-2 " style="width: 500px;  ">
            <div class="mb-3">
                <label for="classe" class="form-label">Nom du cours :</label>
                <select class="form-select" name="classe" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="classe" class="form-label">Nom du cours :</label>
                <select class="form-select" name="classe" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="jours" class="form-label">Jours du cours</label>
                <input type="text" name="jours" class="form-control">
            </div>
            <div class="mb-3">
                <label for="salle" class="form-label">Salle du cours</label>
                <input type="text" name="salle" class="form-control">
            </div>
            <div class="mb-3">
                <label for="debut" class="form-label">Heur du debut</label>
                <input type="time" class="form-control" name="debut">
            </div>
            <div class="mb-3">
                <label for="fin" class="form-label">Heur de fin</label>
                <input type="time" class="form-control" name="fin">
            </div>
            <button type="submit" name="ajout" class="btn btn-primary">Creer le cours</button>
        </form>

        <h2 class="mt-5 pt-5 mx-auto p-2" style="width: 500px;">Liste des cours</h2>
        <?php
    }
    ?>
    <div class="list-group mx-auto p-2" style="width: 500px;">
        <?php
        $Cours = CoursGetAll();
        foreach ($Cours as $Cour) {
            echo "<button type='button' class='list-group-item list-group-item-action justify-content-center'  data-bs-toggle='modal' data-bs-target='#Course{$Cour['id']}'>{$Cour['id']} {$Cour['nom']} {$Cour['code']}</button>";
        }
        ?>
    </div>
    <?php
    $Cours = CoursGetAll();
    foreach ($Cours as $Cour) {
        echo "<div class='modal fade' id='Course{$Cour['id']}' data-bs-keyboard='false' tabindex='-1'
        aria-labelledby='staticBackdropLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='staticBackdropLabel'>Mofication</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <form action='Courses.php' method='post'>
                    <div class='modal-body'>
                        <div class='mb-3'>
                        <label for='nom' class='form-label'>Nom de la Course :</label>
                        <input type='text' name='nom' class='form-control' value='{$Cour['nom']}' >  
                        </div>  
                        <div class='mb-3'>                    
                        <label for='code'>Annee scolaire</label>
                        <input type='text' name='code' class='form-control' value='{$Cour['code']}'>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' name='Suprimer' value='{$Cour['id']}' class='btn btn-danger' data-bs-dismiss='modal'>Suprimer</button>
                        <button type='submit' name='Modifier' value='{$Cour['id']}' class='btn btn-success'>Modifier</button>
                </form>
            </div>
        </div>
    </div></div>";
    }
    echo '<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">' . $message . '</h4>';
    ?>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

</html>