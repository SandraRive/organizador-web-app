<?php
// public/stats.php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = 'Estadísticas';
include __DIR__ . '/../templates/header.php';
?>

<h1>Estadísticas de productividad</h1>
<div class="stats-section">
  <canvas id="tasksChart"></canvas>
</div>
<div class="stats-section">
  <canvas id="notesChart"></canvas>
</div>
<div class="stats-section">
  <canvas id="pomosChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/stats.js"></script>

<?php include __DIR__ . '/../templates/footer.php'; ?>
