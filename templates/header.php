<?php
// templates/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle).' | ' : '' ?>Organizador</title>

  <!-- Bootstrap 5 CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-..."
    crossorigin="anonymous"
  >

  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"
    integrity="sha384-..."
    crossorigin="anonymous"
  >

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Poppins:wght@400;600;700&display=swap"
    rel="stylesheet"
  />

  <!-- Tu CSS personalizado -->
  <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
  <!-- OFFCANVAS SIDEBAR (solo UNO) -->
  <div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarLabel">Navegación</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body p-0">
      <div class="list-group list-group-flush">
        <a href="dashboard.php" class="list-group-item list-group-item-action">Inicio</a>
        <a href="tasks.php" class="list-group-item list-group-item-action">Tareas</a>
        <a href="studies.php" class="list-group-item list-group-item-action">Estudios</a>
        <a href="pomodoro.php" class="list-group-item list-group-item-action">Pomodoro</a>
      </div>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="dashboard.php">
        <i class="fa-solid fa-list-check"></i> Organizador
      </a>
      <!-- OFFCANVAS TOGGLE (solo en pantallas pequeñas) -->
      <button class="btn btn-primary d-lg-none ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
        <i class="fa-solid fa-bars"></i>
      </button>
      <!-- COLLAPSE NAVIGATION -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="tasks.php">Tareas</a></li>
          <li class="nav-item"><a class="nav-link" href="studies.php">Estudios</a></li>
          <li class="nav-item"><a class="nav-link" href="pomodoro.php">Pomodoro</a></li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['username']) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="profile.php">Perfil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="main-content">
