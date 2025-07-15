<?php
// public/dashboard.php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = 'Inicio';
include __DIR__ . '/../templates/header.php';
?>

  <h1>Hola, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
  <p>Bienvenido al dashboard privado.</p>

<?php
include __DIR__ . '/../templates/footer.php';
?>
