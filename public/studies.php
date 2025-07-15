<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

// Recuperar asignaturas del usuario
$stmt = $pdo->prepare("
  SELECT id, name 
  FROM subjects 
  WHERE user_id = ?
  ORDER BY name ASC
");
$stmt->execute([$_SESSION['user_id']]);
$subjects = $stmt->fetchAll();
?>
<?php $pageTitle = 'Estudios'; include __DIR__ . '/../templates/header.php'; ?>

  <h1>Mis Asignaturas</h1>
  <p><a href="create_subject.php">+ Nueva asignatura</a></p>

  <?php if (empty($subjects)): ?>
    <p>No has creado asignaturas aún.</p>
  <?php else: ?>
    <ul class="subject-list">
      <?php foreach ($subjects as $s): ?>
        <li>
          <a href="notes.php?subject_id=<?= $s['id'] ?>">
            <?= htmlspecialchars($s['name']) ?>
          </a>
          [<a href="edit_subject.php?id=<?= $s['id'] ?>">Editar</a>]
          [<a href="delete_subject.php?id=<?= $s['id'] ?>"
              onclick="return confirm('Borrar asignatura y todos sus apuntes?')">
             Borrar
          </a>]
                    <!-- Dentro de studies.php, en el bucle de asignaturas -->
          [<a href="delete_subject.php?id=<?= $s['id'] ?>"
              onclick="return confirm('Borrar asignatura y todos sus apuntes?')">
            Borrar
          </a>]
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

<?php include __DIR__ . '/../templates/footer.php'; ?>
