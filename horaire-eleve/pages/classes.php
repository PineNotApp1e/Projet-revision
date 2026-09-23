<?php
session_start();
include "../includes/header.php";
require_once "../functions/classes.php";
echo Menu("classes");
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["ajout"])) {
        if (count(ClasseSearchBy("nom", $_POST['nom'])) > 0) {
            $_SESSION["message"] = '<div class="alert alert-danger mt-2" role="alert" ><h4 class="alert-heading">La classe ' . $_POST["nom"] . ' est déjà existante.</h4></div>';
        } else if (!ClasseCreate($_POST["nom"], $_POST["annee"])) {
            $_SESSION['message'] = '<div class="alert alert-success mt-2" role="alert" ><h4 class="alert-heading">La classe a été ajoutée avec succès !</h4></div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger mt-2" role="alert" ><h4 class="alert-heading">Erreur pendant la création de la classe</h4></div>';
        }
    } else if (isset($_POST["Modifier"])) {
        if (count(ClasseSearchBy("nom", $_POST['nom'])) > 0) {
            $_SESSION["message"] = '<div class="alert alert-danger mt-2" role="alert" ><h4 class="alert-heading">La classe ' . $_POST["nom"] . ' est déjà existante.</h4></div>';
        } else if (!ClasseUpdate($_POST["Modifier"], $_POST["nom"], $_POST["annee"])) {
            $_SESSION['message'] = '<div class="alert alert-success mt-2" role="alert" ><h4 class="alert-heading">La classe a été modifiée avec succès !</h4></div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger mt-2" role="alert" ><h4 class="alert-heading">Erreur lors de la modification de la classe</h4></div>';

        }
    } else if (isset($_POST["Supprimer"])) {
        if (!ClasseDelete($_POST["Supprimer"])) {
            $_SESSION['message'] = '<div class="alert alert-success mt-2" role="alert" ><h4 class="alert-heading">La classe a été supprimée avec succès !</h4></div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger mt-2" role="alert" ><h4 class="alert-heading">Impossible de supprimer cette classe car elle contient des horaires.</h4></div>';

        }
    }
    header('Location: classes.php');
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
    <form action="classes.php" method="post" class=" pt-5 mt-5 mx-auto p-2 " style="width: 500px;">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la classe :</label>
            <input type="text" name="nom" class="form-control">
        </div>
        <div class="mb-3">
            <label for="annee" class="form-label">Année scolaire :</label>
            <input type="text" name="annee" class="form-control">
        </div>
        <button type="submit" name="ajout" class="btn btn-primary">Créer la classe</button>
        <?php
        echo $message;
        ?>
    </form>
    <h2 class="mt-5 pt-5 mx-auto p-2" style="width: 500px;">Liste des classes</h2>
    <div class="list-group mx-auto p-2" style="width: 500px;">
        <?php
        $classes = ClasseGetAll();
        foreach ($classes as $classe) {
            echo "<button type='button' class='list-group-item list-group-item-action justify-content-center'  data-bs-toggle='modal' data-bs-target='#classe{$classe['id']}'>" . htmlspecialchars($classe['nom']) . " " . htmlspecialchars($classe['annee_scolaire']) . "</button>";
        }
        ?>
    </div>
    <?php
    foreach ($classes as $classe) {
        echo "<div class='modal fade' id='classe{$classe['id']}' data-bs-keyboard='false' tabindex='-1'
        aria-labelledby='staticBackdropLabel' aria-hidden='true'>
        <div class='modal-dialog '>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='staticBackdropLabel'>Modification</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <form action='classes.php' method='post'>
                    <div class='modal-body'>
                        <div class='mb-3'>
                        <label for='nom' class='form-label'>Nom de la classe :</label>
                        <input type='text' name='nom' class='form-control' value='" . htmlspecialchars($classe['nom']) . "' >  
                        </div>  
                        <div class='mb-3'>                    
                        <label for='annee'>Année scolaire :</label>
                        <input type='text' name='annee' class='form-control' value='" . htmlspecialchars($classe['annee_scolaire']) . "'>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' name='Supprimer' value='" . htmlspecialchars($classe['id']) . "' class='btn btn-danger' data-bs-dismiss='modal'>Supprimer</button>
                        <button type='submit' name='Modifier' value='" . htmlspecialchars($classe['id']) . "' class='btn btn-success'>Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>";
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

</html>