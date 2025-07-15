<?php
// public/create_task.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$errors = [];
$title       = '';
$description = '';
$due_date    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos y saneamos
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date    = $_POST['due_date'] ?? '';

    // Validaciones
    if ($title === '') {
        $errors[] = 'El título es obligatorio.';
    }
    if ($due_date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $due_date)) {
        $errors[] = 'La fecha debe tener formato AAAA-MM-DD.';
    }

    // Si no hay errores, insertamos
    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO tasks (user_id, title, description, due_date)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $_SESSION['user_id'],
            $title,
            $description ?: null,
            $due_date ?: null
        ]);
        header('Location: tasks.php');
        exit;
    }
}

$pageTitle = 'Nueva tarea';
include __DIR__ . '/../templates/header.php';
?>

  <h1>Crear nueva tarea</h1>

  <?php if ($errors): ?>
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post" action="">
    <div>
      <label>Título:<br>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>
      </label>
    </div>
    <div>
      <label>Descripción:<br>
        <textarea name="description"><?= htmlspecialchars($description) ?></textarea>
      </label>
    </div>
    <div>
      <label>Fecha de vencimiento (AAAA-MM-DD):<br>
        <input type="date" name="due_date" value="<?= htmlspecialchars($due_date) ?>">
      </label>
    </div>
    <button type="submit">Guardar tarea</button>
    <a href="tasks.php" style="margin-left:1rem;">Cancelar</a>
  </form>

<?php include __DIR__ . '/../templates/footer.php'; ?>
