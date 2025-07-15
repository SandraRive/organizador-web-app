<?php
// public/register.php
require_once __DIR__ . '/../includes/config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $pass     = $_POST['password'] ?? '';
    $pass2    = $_POST['password2'] ?? '';

    // Validaciones
    if (!$username)                        $errors[] = 'El usuario es obligatorio.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
    if (strlen($pass) < 6)                $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
    if ($pass !== $pass2)                 $errors[] = 'Las contraseñas no coinciden.';

    // Comprobar duplicados
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = 'Usuario o email ya registrado.';
        } else {
            // Insertar nuevo usuario
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
            $stmt->execute([$username, $email, $hash]);
            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h2>Registro de usuario</h2>
  <?php if ($errors): ?>
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form method="post">
    <label>Usuario:<br>
      <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>">
    </label><br>
    <label>Email:<br>
      <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
    </label><br>
    <label>Contraseña:<br>
      <input type="password" name="password">
    </label><br>
    <label>Repite contraseña:<br>
      <input type="password" name="password2">
    </label><br>
    <button type="submit">Registrar</button>
  </form>
  <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</body>
</html>
