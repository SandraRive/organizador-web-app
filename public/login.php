<?php
// public/login.php
require_once __DIR__ . '/../includes/config.php';
session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
    if (!$pass)                                     $errors[] = 'Contraseña requerida.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Credenciales incorrectas.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h2>Iniciar sesión</h2>
  <?php if (isset($_GET['registered'])): ?>
    <p>Registro exitoso. Ahora inicia sesión.</p>
  <?php endif; ?>
  <?php if ($errors): ?>
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form method="post">
    <label>Email:<br>
      <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
    </label><br>
    <label>Contraseña:<br>
      <input type="password" name="password">
    </label><br>
    <button type="submit">Entrar</button>
  </form>
  <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
</body>
</html>
