<?php
// public/edit_task.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$errors = [];

// 1) Comprobar ID válido
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: tasks.php');
    exit;
}

// 2) Cargar datos existentes (solo description)
$stmt = $pdo->prepare("SELECT id, description FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$task = $stmt->fetch();
if (!$task) {
    header('Location: tasks.php');
    exit;
}

// Inicializar valores para el formulario
$description = $task['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 3) Recoger y validar POST
    $description = trim($_POST['description'] ?? '');
    if ($description === '') {
        $errors[] = 'La descripción es obligatoria.';
    }

    // 4) Si ok, actualizar y redirigir
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE tasks SET description = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([
            $description,
            $id,
            $_SESSION['user_id']
        ]);
        header('Location: tasks.php');
        exit;
    }
}

$pageTitle = 'Editar tarea';
include __DIR__ . '/../templates/header.php';
?>

<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
      <h2 class="mb-0"><i class="fa-solid fa-pen-to-square"></i> Editar tarea</h2>
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
          <textarea
            id="description"
            name="description"
            class="form-control"
            rows="4"
            required
          ><?= htmlspecialchars($description) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-save me-1"></i> Guardar cambios
        </button>
        <a href="tasks.php" class="btn btn-link">Cancelar</a>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
