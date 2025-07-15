<?php
// public/login.php
require_once __DIR__ . '/../includes/config.php';
session_start();

$errors = [];
$email = '';
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

$pageTitle = 'Iniciar sesión';
include __DIR__ . '/../templates/header.php';
?>

<div class="d-flex align-items-center justify-content-center min-vh-100 login-bg">
  <div class="card shadow-lg login-card">
    <div class="card-header text-center bg-primary text-white">
      <h2 class="mb-0"><i class="fa-solid fa-lock me-2"></i>Iniciar Sesión</h2>
    </div>
    <div class="card-body">
      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php elseif (isset($_GET['registered'])): ?>
        <div class="alert alert-success">
          Registro exitoso. Ahora inicia sesión.
        </div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            class="form-control form-control-lg"
            value="<?= htmlspecialchars($email) ?>"
            required
          >
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Contraseña</label>
          <input
            type="password"
            id="password"
            name="password"
            class="form-control form-control-lg"
            required
          >
        </div>
        <button type="submit" class="btn btn-primary btn-lg w-100">
          Entrar
        </button>
      </form>
      <p class="text-center mt-3">
        ¿No tienes cuenta?
        <a href="register.php" class="link-primary">Regístrate</a>
      </p>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
