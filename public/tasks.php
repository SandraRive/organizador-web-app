<?php
// public/tasks.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

// Recuperamos todas las tareas del usuario
$stmt = $pdo->prepare("
    SELECT id, title, due_date, status 
    FROM tasks 
    WHERE user_id = ? 
    ORDER BY 
      CASE WHEN due_date IS NULL THEN 1 ELSE 0 END, 
      due_date ASC, created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll();
?>
<?php $pageTitle = 'Tareas'; include __DIR__ . '/../templates/header.php'; ?>

  <h1>Mis Tareas</h1>
  <p><a href="create_task.php">+ Nueva tarea</a></p>

  <?php if (empty($tasks)): ?>
    <p>No tienes tareas todavía.</p>
  <?php else: ?>
    <table class="tasks-table">
      <thead>
        <tr>
          <th>Título</th>
          <th>Vence</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tasks as $task): ?>
          <tr>
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td>
              <?= $task['due_date'] 
                  ? date('d/m/Y', strtotime($task['due_date'])) 
                  : '-' ?>
            </td>
            <td><?= ucfirst($task['status']) ?></td>
            <td>
              <a href="edit_task.php?id=<?= $task['id'] ?>">Editar</a> |
              <a href="delete_task.php?id=<?= $task['id'] ?>"
                onclick="return confirm('¿Seguro que quieres borrar esta tarea?')">
                Borrar
              </a>
              <?php if ($task['status'] === 'pending'): ?>
                <a href="toggle_task.php?id=<?= $task['id'] ?>&action=done">
                  Marcar como hecha
                </a>
              <?php else: ?>
                <a href="toggle_task.php?id=<?= $task['id'] ?>&action=pending">
                  Marcar como pendiente
                </a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

<?php include __DIR__ . '/../templates/footer.php'; ?>
