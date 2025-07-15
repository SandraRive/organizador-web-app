<?php
// public/edit_note.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: studies.php'); exit;
}

// Cargar apunte y subject
$stmt = $pdo->prepare("
  SELECT n.*, s.user_id, s.name AS subject_name
    FROM notes n
    JOIN subjects s ON n.subject_id = s.id
   WHERE n.id = ? AND s.user_id = ?
");
$stmt->execute([$id, $_SESSION['user_id']]);
$note = $stmt->fetch();
if (!$note) {
    header('Location: studies.php'); exit;
}

$subject_id = $note['subject_id'];
$errors     = [];
$title      = $note['title'];
$content    = $note['content'];
$link       = $note['link'];

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
          UPDATE notes
             SET title   = ?, 
                 content = ?, 
                 link    = ?
           WHERE id = ? AND subject_id = ?
        ");
        $stmt->execute([
          $title,
          $content ?: null,
          $link    ?: null,
          $id,
          $subject_id
        ]);
        header("Location: notes.php?subject_id={$subject_id}");
        exit;
    }
}

$pageTitle = 'Editar apunte';
include __DIR__ . '/../templates/header.php';
?>

  <h1>Editar apunte en “<?= htmlspecialchars($note['subject_name']) ?>”</h1>
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
    <button type="submit">Guardar cambios</button>
    <a href="notes.php?subject_id=<?= $subject_id ?>"
       style="margin-left:1rem;">Cancelar</a>
  </form>

<?php include __DIR__ . '/../templates/footer.php'; ?>
