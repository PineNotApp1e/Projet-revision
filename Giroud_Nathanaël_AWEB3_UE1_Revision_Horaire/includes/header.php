<?php

function Menu($page): string
{
  return '<header class="fixed-top bg-white border-bottom fs-3">
    <ul class="nav nav-underline justify-content-center py-3">
  <li class="nav-item">
    <a class="nav-link  ' . ($page == 'index' ? 'active' : '') . '" ' . ($page == 'index' ? 'aria-current="page"' : '') . ' href="' . ($page != 'index' ? '../' : '') . 'index.php">Accueil</a>
  </li>
  <li class="nav-item">
    <a class="nav-link ' . ($page == 'classes' ? 'active' : '') . '" ' . ($page == 'classes' ? 'aria-current="page"' : '') . ' href="' . ($page == 'index' ? 'pages/' : '') . 'classes.php">Classes</a>
  </li>
  <li class="nav-item">
    <a class="nav-link ' . ($page == 'cours' ? 'active' : '') . '" ' . ($page == 'cours' ? 'aria-current="page"' : '') . ' href="' . ($page == 'index' ? 'pages/' : '') . 'cours.php">Cours</a>
  </li>
  <li class="nav-item">
    <a class="nav-link ' . ($page == 'horaire' ? 'active' : '') . '" ' . ($page == 'horaire' ? 'aria-current="page"' : '') . ' href="' . ($page == 'index' ? 'pages/' : '') . 'horaire.php">Horaires</a>
  </li>
</ul>
</header>';
}
?>