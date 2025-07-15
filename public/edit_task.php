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

// 2) Cargar datos existentes
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$task = $stmt->fetch();
if (!$task) {
    header('Location: tasks.php');
    exit;
}

// Inicializar valores para el formulario
$title       = $task['title'];
$description = $task['description'];
$due_date    = $task['due_date'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 3) Recoger y validar POST
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date    = $_POST['due_date'] ?? '';

    if ($title === '') {
        $errors[] = 'El título es obligatorio.';
    }
    if ($due_date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $due_date)) {
        $errors[] = 'La fecha debe tener formato AAAA-MM-DD.';
    }

    // 4) Si ok, actualizar y redirigir
    if (empty($errors)) {
        $stmt = $pdo->prepare("
            UPDATE tasks
               SET title       = ?,
                   description = ?,
                   due_date    = ?
             WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([
            $title,
            $description ?: null,
            $due_date ?: null,
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

  <h1>Editar tarea</h1>

  <?php if ($errors): ?>
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post">
    <div>
      <label>Título:<br>
        <input type="text" name="title" 
               value="<?= htmlspecialchars($title) ?>" required>
      </label>
    </div>
    <div>
      <label>Descripción:<br>
        <textarea name="description"><?= htmlspecialchars($description) ?></textarea>
      </label>
    </div>
    <div>
      <label>Fecha de vencimiento:<br>
        <input type="date" name="due_date" 
               value="<?= htmlspecialchars($due_date) ?>">
      </label>
    </div>
    <button type="submit">Guardar cambios</button>
    <a href="tasks.php" style="margin-left:1rem;">Cancelar</a>
  </form>

<?php include __DIR__ . '/../templates/footer.php'; ?>
