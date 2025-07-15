<?php
// public/pomodoro.php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = 'Pomodoro';
include __DIR__ . '/../templates/header.php';
?>

<div class="pomodoro-container">
  <!-- Selección de modo -->
  <div class="pomodoro-modes">
    <button data-mode="work" class="mode-btn active">Trabajo</button>
    <button data-mode="shortBreak" class="mode-btn">Descanso corto</button>
    <button data-mode="longBreak" class="mode-btn">Descanso largo</button>
  </div>

  <!-- Pantalla del cronómetro -->
  <div id="timer-display">25:00</div>

  <!-- Controles -->
  <div class="pomodoro-controls">
    <button id="start-btn">Iniciar</button>
    <button id="pause-btn" disabled>Pausar</button>
    <button id="reset-btn">Reiniciar</button>
  </div>

  <!-- Ajustes de duración -->
  <div class="pomodoro-settings">
    <label>Trabajo <input type="number" id="work-duration" value="25" min="1" /> min</label>
    <label>Descanso corto <input type="number" id="short-break-duration" value="5" min="1" /> min</label>
    <label>Descanso largo <input type="number" id="long-break-duration" value="15" min="1" /> min</label>
    <button id="apply-settings-btn">Aplicar</button>
  </div>
</div>

<script src="assets/js/pomodoro.js"></script>

<?php include __DIR__ . '/../templates/footer.php'; ?>
