<?php
// public/tasks.php
require_once __DIR__.'/../includes/auth.php';
require_once __DIR__.'/../includes/config.php';

$pageTitle = 'Tareas';

// Recuperar tareas existentes
$stmt = $pdo->prepare(
    "SELECT id, description, status FROM tasks WHERE user_id = ? ORDER BY created_at DESC"
);
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll();

include __DIR__.'/../templates/header.php';
?>

<div class="container my-5">
  <div class="card shadow-sm tasks-card">
    <div class="card-header text-white">
      <h2 class="mb-0"><i class="fa-solid fa-list"></i> Mis tareas</h2>
    </div>
    <div class="card-body">
      <!-- Botón nueva tarea -->
      <a href="create_task.php" class="btn btn-success mb-4">
        <i class="fa-solid fa-plus"></i> Nueva tarea
      </a>

      <?php if (empty($tasks)): ?>
        <p class="text-muted">No tienes tareas.</p>
      <?php else: ?>
        <table class="table table-striped align-middle">
          <thead class="table-light">
            <tr>
              <th>Descripción</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tasks as $t): ?>
            <tr>
              <td><?= htmlspecialchars($t['description']) ?></td>
              <td>
                <span class="badge bg-<?= $t['status']==='done' ? 'success':'warning' ?>">
                  <?= ucfirst($t['status']) ?>
                </span>
              </td>
              <td>
                <a href="edit_task.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="delete_task.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__.'/../templates/footer.php'; ?>