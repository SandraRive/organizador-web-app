<?php
// public/pomodoro.php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = 'Pomodoro';
include __DIR__ . '/../templates/header.php';
?>

<div class="container my-5">
  <div class="row g-4">

    <!-- Temporizador -->
    <div class="col-12 col-md-6">
      <div class="card shadow-sm pomodoro-card text-center">
        <div class="card-header text-white">
          <h3 class="mb-0"><i class="fa-solid fa-clock"></i> Temporizador</h3>
        </div>
        <div class="card-body">
          <div id="timer-display" class="display-1 mb-4">25:00</div>
          <button id="start-btn" class="btn btn-success me-2">
            <i class="fa-solid fa-play"></i>
          </button>
          <button id="pause-btn" class="btn btn-warning me-2" disabled>
            <i class="fa-solid fa-pause"></i>
          </button>
          <button id="reset-btn" class="btn btn-danger">
            <i class="fa-solid fa-rotate"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Ajustes -->
    <div class="col-12 col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
          <h3 class="mb-0"><i class="fa-solid fa-sliders"></i> Ajustes</h3>
        </div>
        <div class="card-body">
          <form id="settings-form">
            <div class="mb-3">
              <label for="work-duration" class="form-label">Trabajo (min)</label>
              <input
                type="number"
                id="work-duration"
                class="form-control"
                value="25"
                min="1"
              >
            </div>
            <div class="mb-3">
              <label for="short-break-duration" class="form-label">Descanso corto (min)</label>
              <input
                type="number"
                id="short-break-duration"
                class="form-control"
                value="5"
                min="1"
              >
            </div>
            <div class="mb-3">
              <label for="long-break-duration" class="form-label">Descanso largo (min)</label>
              <input
                type="number"
                id="long-break-duration"
                class="form-control"
                value="15"
                min="1"
              >
            </div>
            <button
              type="button"
              id="apply-settings-btn"
              class="btn btn-primary"
            >
              <i class="fa-solid fa-floppy-disk me-1"></i> Aplicar
            </button>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="assets/js/pomodoro.js"></script>
<?php include __DIR__ . '/../templates/footer.php'; ?>
