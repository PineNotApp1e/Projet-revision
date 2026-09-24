<?php

include "includes/header.php";
require_once "functions/cours.php";
require_once "functions/classes.php";
require_once "functions/creneaux.php";

echo Menu("index");
$classes = ClasseGetAll();
$cours = CoursGetAll();
$creneaux = CreneauxGetAll();
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

<body class="row align-items-start">
    <div class="list-group mx-auto p-2" style="width: 500px;">
        <h2 class="mt-5 pt-5 mx-auto p-2" style="width: 500px;">Liste des classes</h2>

        <?php
        foreach ($classes as $classe) {
            echo "<button type='button' class='list-group-item list-group-item-action justify-content-center'  data-bs-toggle='modal' data-bs-target='#classe{$classe['id']}'>" . htmlspecialchars($classe['nom']) ." ". htmlspecialchars($classe['annee_scolaire']) . "</button>";
        }
        ?>
    </div>
    <div class="list-group mx-auto p-2" style="width: 500px;">
        <h2 class="mt-5 pt-5 mx-auto p-2" style="width: 500px;">Liste des cours</h2>

        <?php
        foreach ($cours as $cour) {
            echo "<button type='button' class='list-group-item list-group-item-action justify-content-center'  data-bs-toggle='modal' data-bs-target='#Cours{$cour['id']}'>" . htmlspecialchars($cour['nom']) . " " . htmlspecialchars($cour['code']) . "</button>";
        }
        ?>
    </div>
    <div class="list-group mx-auto p-2" style="width: 500px;">
        <h2 class="mt-5 pt-5 mx-auto p-2" style="width: 500px;">Liste des horaires</h2>

        <?php
        foreach ($creneaux as $creneau) {
            echo "<button type='button' class='list-group-item list-group-item-action justify-content-center' data-bs-toggle='modal' data-bs-target='#Creneaux{$creneau['id']}'><b>" . htmlspecialchars($creneau['classe']) . " : </b>" . htmlspecialchars($creneau['cours']) . " de " . htmlspecialchars($creneau['heure_debut']) . " à " . htmlspecialchars($creneau['heure_fin']) . " le " . htmlspecialchars($creneau['jour']) . " en salle " . htmlspecialchars($creneau['salle']) . "</button>";
        }
        ?>
    </div>
    <?php
    foreach ($classes as $classe) {
        echo "<div class='modal fade' id='classe{$classe['id']}' data-bs-keyboard='false' tabindex='-1'
        aria-labelledby='staticBackdropLabel' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='staticBackdropLabel'>{$classe['nom']}</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <div class='d-flex justify-content-evenly'>";
        $horaire = CreneauxGetByClasse($classe['id']);
        $jour = "";
        foreach ($horaire as $value) {
            if ($jour != $value['jour']) {
                if ($jour != "") {
                    echo "</div>";
                }
                $jour = $value['jour'];
                echo "<div><h1 class='modal-title fs-5' id='staticBackdropLabel'>{$jour}</h1>";
            }
            echo '<div class="card mb-3" style="max-width: 18rem;">
                                    <div class="card-header">' . $value['cours'] . '</div>
                        <div class="card-body">
                            <p class="card-text">Début : ' . $value['heure_debut'] . '</p>
                            <p class="card-text">Fin : ' . $value['heure_fin'] . '</p>
                            <p class="card-text">Salle : ' . $value['salle'] . '</p>
                        </div></div>';
        }
        if (count($horaire) > 0) {
            echo "</div>";
        }
        echo "</div>
                </div>
            </div>
        </div>
    </div></div>";
    }
    foreach ($cours as $cour) {
        echo "<div class='modal fade' id='Cours{$cour['id']}' data-bs-keyboard='false' tabindex='-1'
        aria-labelledby='staticBackdropLabel' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='staticBackdropLabel'>{$cour['code']}</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <div class='d-flex justify-content-evenly'>";
        $horaire = CreneauxGetByCours($cour['id']);
        $jour = "";
        foreach ($horaire as $value) {
            if ($jour != $value['jour']) {
                if ($jour != "") {
                    echo "</div>";
                }
                $jour = $value['jour'];
                echo "<div><h1 class='modal-title fs-5' id='staticBackdropLabel'>{$jour}</h1>";
            }
            echo '<div class="card mb-3" style="max-width: 18rem;">
                                    <div class="card-header">' . $value['classe'] . '</div>
                        <div class="card-body">
                            <p class="card-text">Début : ' . $value['heure_debut'] . '</p>
                            <p class="card-text">Fin : ' . $value['heure_fin'] . '</p>
                            <p class="card-text">Salle : ' . $value['salle'] . '</p>
                        </div></div>';
        }
        if (count($horaire) > 0) {
            echo "</div>";
        }
        echo "</div>
                </div>
            </div>
        </div>
    </div></div>";
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

</html>