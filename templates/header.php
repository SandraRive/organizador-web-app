<?php
// templates/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle).' | ' : '' ?>Organizador</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <header class="main-header">
    <div class="logo">
      <a href="dashboard.php">🗂 Organizador</a>
    </div>
    <button class="mobile-toggle" id="mobileToggle">☰</button>
    <nav class="top-nav">
      <ul>
        <li><a href="dashboard.php">Inicio</a></li>
        <!-- AÑADE AQUÍ -->
        <li><a href="tasks.php">Tareas</a></li>
        <!-- ---------- -->
        <li><a href="studies.php">Estudios</a></li>
        <li><a href="pomodoro.php">Pomodoro</a></li>
        <li><a href="profile.php"><?= htmlspecialchars($_SESSION['username']) ?></a></li>
        <li><a href="logout.php">Salir</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <aside class="sidebar">
      <ul>
        <li><a href="dashboard.php">Inicio</a></li>
        <!-- AÑADE AQUÍ -->
        <li><a href="tasks.php">Tareas</a></li>
        <!-- ---------- -->
        <li><a href="studies.php">Estudios</a></li>
        <li><a href="pomodoro.php">Pomodoro</a></li>
      </ul>
    </aside>

    <main class="main-content">
