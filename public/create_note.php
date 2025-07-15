<?php
// public/create_note.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;
if ($subject_id <= 0) {
    header('Location: studies.php'); exit;
}

// Verificar asignatura
$stmt = $pdo->prepare("SELECT id,name FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $_SESSION['user_id']]);
$subject = $stmt->fetch();
if (!$subject) {
    header('Location: studies.php'); exit;
}

$errors = [];
$title   = '';
$content = '';
$link    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $link    = trim($_POST['link'] ?? '');

    if ($title === '') {
        $errors[] = 'El título es obligatorio.';
    }
    if ($link !== '' && !filter_var($link, FILTER_VALIDATE_URL)) {
        $errors[] = 'El enlace no es una URL válida.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
          INSERT INTO notes (subject_id, title, content, link)
          VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
          $subject_id,
          $title,
          $content ?: null,
          $link    ?: null
        ]);
        header("Location: notes.php?subject_id={$subject_id}");
        exit;
    }
}

$pageTitle = 'Nuevo apunte';
include __DIR__ . '/../templates/header.php';
?>

  <h1>Crear apunte en “<?= htmlspecialchars($subject['name']) ?>”</h1>
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
      <label>Contenido / Notas:<br>
        <textarea name="content"><?= htmlspecialchars($content) ?></textarea>
      </label>
    </div>
    <div>
      <label>Enlace (opcional):<br>
        <input type="url" name="link"
               value="<?= htmlspecialchars($link) ?>">
      </label>
    </div>
    <button type="submit">Guardar apunte</button>
    <a href="notes.php?subject_id=<?= $subject_id ?>"
       style="margin-left:1rem;">Cancelar</a>
  </form>

<?php include __DIR__ . '/../templates/footer.php'; ?>

