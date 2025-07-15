<?php
// public/studies.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$pageTitle = 'Estudios';
include __DIR__ . '/../templates/header.php';

// Recuperar asignaturas
$stmt = $pdo->prepare("
  SELECT id, name 
    FROM subjects 
   WHERE user_id = ?
   ORDER BY name ASC
");
$stmt->execute([$_SESSION['user_id']]);
$subjects = $stmt->fetchAll();
?>

<div class="container my-5">
  <div class="card shadow-sm studies-card">
    <div class="card-header text-white">
      <h2 class="mb-0"><i class="fa-solid fa-book-open"></i> Mis Asignaturas</h2>
    </div>
    <div class="card-body">
      <a href="create_subject.php" class="btn btn-success mb-4">
        <i class="fa-solid fa-plus"></i> Nueva Asignatura
      </a>

      <?php if (empty($subjects)): ?>
        <p class="text-muted">No has creado asignaturas aún.</p>
      <?php else: ?>
        <ul class="list-group">
          <?php foreach ($subjects as $s): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="notes.php?subject_id=<?= $s['id'] ?>">
                <?= htmlspecialchars($s['name']) ?>
              </a>
              <div>
                <a href="edit_subject.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="delete_subject.php?id=<?= $s['id'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('¿Borrar asignatura y todos sus apuntes?')">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
