<?php
include "../includes/header.php";
require_once "../functions/cours.php";


echo Menu("cours");
$message = "";
if (isset($_POST["ajout"])) {
    $message = CoursCreate($_POST["nom"], $_POST["code"]);
} else if (isset($_POST["Modifier"])) {
    $message = CoursUpdate($_POST["Modifier"], $_POST["nom"], $_POST["code"]);
} else if (isset($_POST["Suprimer"])) {
    $message = CoursDelete($_POST["Suprimer"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet hoiraire</title>
</head>

<body >
    <form action="cours.php" method="post" class=" pt-5 mt-5 mx-auto p-2 " style="width: 500px;">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du cours :</label>
            <input type="text" name="nom" class="form-control">
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Code du cours</label>
            <input type="text" name="code" class="form-control">
        </div>
        <button type="submit" name="ajout" class="btn btn-primary">Creer le cours</button>
    </form>
    <h2 class="mt-5 pt-5 mx-auto p-2" style="width: 500px;">Liste des cours</h2>
    <div class="list-group mx-auto p-2" style="width: 500px;">
        <?php
        $Cours = CoursGetAll();
        foreach ($Cours as $Cour) {
            echo "<button type='button' class='list-group-item list-group-item-action justify-content-center'  data-bs-toggle='modal' data-bs-target='#Cours{$Cour['id']}'>{$Cour['id']} {$Cour['nom']} {$Cour['code']}</button>";
        }
        ?>
    </div>
    <?php
    $Cours = CoursGetAll();
    foreach ($Cours as $Cour) {
        echo "<div class='modal fade' id='Cours{$Cour['id']}' data-bs-keyboard='false' tabindex='-1'
        aria-labelledby='staticBackdropLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='staticBackdropLabel'>Mofication</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <form action='cours.php' method='post'>
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
    if($message != ""){
    echo '<div class="alert alert-primary" role="alert" class=" pt-5 mt-5 mx-auto p-2" style="width: 500px;">
  <h4 class="alert-heading">'.$message.'</h4>';}
    ?>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

</html>