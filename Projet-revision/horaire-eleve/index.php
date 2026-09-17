<?php

include "includes/header.php";
require_once "functions/cours.php";
require_once "functions/classes.php";

echo Menu("index");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet hoiraire</title>
</head>

<body class="row align-items-start">
    <div class="list-group mx-auto p-2" style="width: 500px;">
        <h2 class="mt-5 pt-5 mx-auto p-2" style="width: 500px;">Liste des classes</h2>

        <?php
        $classes = ClasseGetAll();
        foreach ($classes as $classe) {
            echo "<button type='button' class='list-group-item list-group-item-action justify-content-center'  data-bs-toggle='modal' data-bs-target='#classe{$classe['id']}'>{$classe['id']} {$classe['nom']} {$classe['annee_scolaire']}</button>";
        }
        ?>
    </div>
    <div class="list-group mx-auto p-2" style="width: 500px;">
        <h2 class="mt-5 pt-5 mx-auto p-2" style="width: 500px;">Liste des cours</h2>

        <?php
        $Cours = CoursGetAll();
        foreach ($Cours as $Cour) {
            echo "<button type='button' class='list-group-item list-group-item-action justify-content-center'  data-bs-toggle='modal' data-bs-target='#Course{$Cour['id']}'>{$Cour['id']} {$Cour['nom']} {$Cour['code']}</button>";
        }
        ?>
    </div>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

</html>