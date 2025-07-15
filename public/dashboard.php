<?php
// public/dashboard.php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = 'Inicio';
include __DIR__ . '/../templates/header.php';
?>

<!-- Hero Section -->
<section class="hero-section d-flex align-items-center justify-content-center text-center text-white">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1 class="hero-title animate__animated animate__fadeInDown">¡Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
      Organiza tus tareas, estudios y pomodoros en un solo lugar.
    </p>
    <a href="tasks.php" class="btn btn-lg btn-light hero-btn animate__animated animate__zoomIn animate__delay-2s">
      <i class="fa-solid fa-check-circle me-2"></i> Ver mis Tareas
    </a>
  </div>
</section>


<!-- Cards Section -->
<div class="container py-5">
  <div class="row g-4">
    <div class="col-12 col-md-4">
      <div class="card h-100 border-0 shadow-lg hover-scale">
        <img src="assets/img/tareas.png" class="card-img-top" alt="Tareas">
        <div class="card-body text-center">
          <h5 class="card-title fw-bold"><i class="fa-solid fa-list"></i> Tareas de Hoy</h5>
          <p class="card-text">Gestiona tus tareas pendientes y marca lo completado.</p>
          <a href="tasks.php" class="btn btn-primary">Ir a Tareas</a>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card h-100 border-0 shadow-lg hover-scale">
        <img src="assets/img/libros.png" class="card-img-top" alt="Estudios">
        <div class="card-body text-center">
          <h5 class="card-title fw-bold"><i class="fa-solid fa-book-open-reader"></i> Estudios</h5>
          <p class="card-text">Organiza tus asignaturas y apuntes en un solo lugar.</p>
          <a href="studies.php" class="btn btn-primary">Ver Estudios</a>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card h-100 border-0 shadow-lg hover-scale">
        <img src="assets/img/pomodoro.png" class="card-img-top" alt="Pomodoro">
        <div class="card-body text-center">
          <h5 class="card-title fw-bold"><i class="fa-solid fa-clock"></i> Pomodoro</h5>
          <p class="card-text">Inicia tu próxima sesión de concentración con temporizador.</p>
          <a href="pomodoro.php" class="btn btn-primary">Comenzar Pomodoro</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
