<?php
// public/create_subject.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$errors = [];
$name = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $errors[] = 'El nombre de la asignatura es obligatorio.';
    }
    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO subjects (user_id, name)
            VALUES (?, ?)
        ");
        $stmt->execute([$_SESSION['user_id'], $name]);
        header('Location: studies.php');
        exit;
    }
}

$pageTitle = 'Nueva asignatura';
include __DIR__ . '/../templates/header.php';
?>

  <h1>Crear asignatura</h1>
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
    <button type="submit">Crear</button>
    <a href="studies.php" style="margin-left:1rem;">Cancelar</a>
  </form>

<?php include __DIR__ . '/../templates/footer.php'; ?>
