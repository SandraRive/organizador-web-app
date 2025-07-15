<?php
// public/profile.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$errors   = [];
$success  = '';

// 1) Recoger datos actuales
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// 2) Procesar formulario de actualización de perfil
if (isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    if ($username === '' || $email === '') {
        $errors[] = 'Usuario y email no pueden estar vacíos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email no válido.';
    } else {
        // Comprobar duplicados en otros usuarios
        $stmt = $pdo->prepare("
          SELECT id FROM users WHERE (username = ? OR email = ?) AND id <> ?
        ");
        $stmt->execute([$username, $email, $_SESSION['user_id']]);
        if ($stmt->fetch()) {
            $errors[] = 'El nombre o el email ya están en uso.';
        } else {
            // Actualizar
            $upd = $pdo->prepare("
              UPDATE users SET username = ?, email = ? WHERE id = ?
            ");
            $upd->execute([$username, $email, $_SESSION['user_id']]);
            $_SESSION['username'] = $username;
            $success = 'Perfil actualizado correctamente.';
            $user['username'] = $username;
            $user['email']    = $email;
        }
    }
}

// 3) Procesar formulario de cambio de contraseña
if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $current = $_POST['current_password'] ?? '';
    $new1    = $_POST['new_password'] ?? '';
    $new2    = $_POST['new_password2'] ?? '';

    if (!$current || !$new1 || !$new2) {
        $errors[] = 'Rellena todos los campos de contraseña.';
    } elseif ($new1 !== $new2) {
        $errors[] = 'Las nuevas contraseñas no coinciden.';
    } elseif (strlen($new1) < 6) {
        $errors[] = 'La nueva contraseña debe tener al menos 6 caracteres.';
    } else {
        // Verificar contraseña actual
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $hash = $stmt->fetchColumn();
        if (!password_verify($current, $hash)) {
            $errors[] = 'Contraseña actual incorrecta.';
        } else {
            // Actualizar al nuevo hash
            $newHash = password_hash($new1, PASSWORD_DEFAULT);
            $upd = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $upd->execute([$newHash, $_SESSION['user_id']]);
            $success = 'Contraseña cambiada con éxito.';
        }
    }
}

// Página
$pageTitle = 'Perfil';
include __DIR__ . '/../templates/header.php';
?>

  <h1>Mi Perfil</h1>

  <?php if ($errors): ?>
    <div class="alert alert-error">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success">
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>

  <!-- Formulario de perfil -->
  <section class="profile-section">
    <h2>Actualizar perfil</h2>
    <form method="post">
      <input type="hidden" name="action" value="update_profile">
      <label>Usuario:<br>
        <input type="text" name="username"
               value="<?= htmlspecialchars($user['username']) ?>" required>
      </label><br>
      <label>Email:<br>
        <input type="email" name="email"
               value="<?= htmlspecialchars($user['email']) ?>" required>
      </label><br>
      <button type="submit">Guardar cambios</button>
    </form>
  </section>

  <!-- Formulario de contraseña -->
  <section class="profile-section">
    <h2>Cambiar contraseña</h2>
    <form method="post">
      <input type="hidden" name="action" value="change_password">
      <label>Contraseña actual:<br>
        <input type="password" name="current_password" required>
      </label><br>
      <label>Nueva contraseña:<br>
        <input type="password" name="new_password" required>
      </label><br>
      <label>Repetir nueva contraseña:<br>
        <input type="password" name="new_password2" required>
      </label><br>
      <button type="submit">Cambiar contraseña</button>
    </form>
  </section>

  <!-- Ajustes de tema -->
  <section class="profile-section">
    <h2>Tema de la aplicación</h2>
    <label>
      <input type="radio" name="theme" value="light" checked> Claro
    </label>
    <label>
      <input type="radio" name="theme" value="dark"> Oscuro
    </label>
    <p>(El tema se aplicará inmediatamente y se guardará en tu navegador.)</p>
  </section>

  <script>
    // Tema persistente en localStorage
    const root = document.documentElement;
    const saved = localStorage.getItem('appTheme') || 'light';
    // Aplicar al cargar
    root.setAttribute('data-theme', saved);
    document.querySelector(`input[name=theme][value=${saved}]`).checked = true;

    document.querySelectorAll('input[name=theme]').forEach(el => {
      el.addEventListener('change', () => {
        localStorage.setItem('appTheme', el.value);
        root.setAttribute('data-theme', el.value);
      });
    });
  </script>

<?php include __DIR__ . '/../templates/footer.php'; ?>
