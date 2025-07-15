<?php
// public/notes.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

// 1) Validar subject_id
$subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;
if ($subject_id <= 0) {
    header('Location: studies.php');
    exit;
}

// 2) Comprobar que la asignatura existe y pertenece al usuario
$stmt = $pdo->prepare("
  SELECT name 
    FROM subjects 
   WHERE id = ? AND user_id = ?
");
$stmt->execute([$subject_id, $_SESSION['user_id']]);
$subject = $stmt->fetch();
if (!$subject) {
    header('Location: studies.php');
    exit;
}

// 3) Recuperar apuntes
$stmt = $pdo->prepare("
  SELECT id, title, link, created_at 
    FROM notes 
   WHERE subject_id = ?
   ORDER BY created_at DESC
");
$stmt->execute([$subject_id]);
$notes = $stmt->fetchAll();

$pageTitle = 'Apuntes: ' . htmlspecialchars($subject['name']);
include __DIR__ . '/../templates/header.php';
?>

  <h1>Apuntes de “<?= htmlspecialchars($subject['name']) ?>”</h1>
  <p>
    <a href="create_note.php?subject_id=<?= $subject_id ?>">+ Nuevo apunte</a>
    &nbsp;|&nbsp;
    <a href="studies.php">← Volver a asignaturas</a>
  </p>

  <?php if (empty($notes)): ?>
    <p>No hay apuntes todavía.</p>
  <?php else: ?>
    <table class="notes-table">
      <thead>
        <tr>
          <th>Título</th>
          <th>Enlace</th>
          <th>Creado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($notes as $n): ?>
          <tr>
            <td><?= htmlspecialchars($n['title']) ?></td>
            <td>
              <?php if ($n['link']): ?>
                <a href="<?= htmlspecialchars($n['link']) ?>" target="_blank">Ver</a>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></td>
            <td>
              <a href="edit_note.php?id=<?= $n['id'] ?>">Editar</a> |
              <a href="delete_note.php?id=<?= $n['id'] ?>"
                 onclick="return confirm('¿Eliminar este apunte?')">
                Borrar
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

<?php include __DIR__ . '/../templates/footer.php'; ?>
