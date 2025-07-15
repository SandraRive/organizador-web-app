<?php
// public/edit_subject.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$errors = [];
$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: studies.php'); exit;
}

// Cargar asignatura
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$subject = $stmt->fetch();
if (!$subject) {
    header('Location: studies.php'); exit;
}

$name = $subject['name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $errors[] = 'El nombre de la asignatura es obligatorio.';
    }
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE subjects SET name = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$name, $id, $_SESSION['user_id']]);
        header('Location: studies.php'); exit;
    }
}

$pageTitle = 'Editar asignatura';
include __DIR__ . '/../templates/header.php';
?>

  <h1>Editar asignatura</h1>
  <?php if ($errors): ?>
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post">
    <label>Nombre:<br>
      <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
    </label><br>
    <button type="submit">Guardar cambios</button>
    <a href="studies.php" style="margin-left:1rem;">Cancelar</a>
  </form>

<?php include __DIR__ . '/../templates/footer.php'; ?>
