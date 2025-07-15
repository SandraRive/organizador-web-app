<?php
// public/create_task.php
require_once __DIR__.'/../includes/auth.php';
require_once __DIR__.'/../includes/config.php';

$errors = [];
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = trim($_POST['description'] ?? '');
    if ($description === '') {
        $errors[] = 'La descripción es obligatoria.';
    }
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, description) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $description]);
        header('Location: tasks.php');
        exit;
    }
}

$pageTitle = 'Nueva tarea';
include __DIR__.'/../templates/header.php';
?>

<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
      <h2 class="mb-0"><i class="fa-solid fa-plus"></i> Crear tarea</h2>
    </div>
    <div class="card-body">
      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label for="description" class="form-label">Descripción</label>
          <input
            type="text"
            id="description"
            name="description"
            class="form-control"
            value="<?= htmlspecialchars($description) ?>"
            required
          >
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-save me-1"></i> Guardar
        </button>
        <a href="tasks.php" class="btn btn-link">Cancelar</a>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__.'/../templates/footer.php'; ?>
