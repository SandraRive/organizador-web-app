<?php
// public/record_pomodoro.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$data = json_decode(file_get_contents('php://input'), true);
if (
  isset($data['mode'], $data['duration']) &&
  in_array($data['mode'], ['work','shortBreak','longBreak'], true) &&
  is_int($data['duration'])
) {
  $stmt = $pdo->prepare("
    INSERT INTO pomodoros (user_id, mode, duration)
    VALUES (?, ?, ?)
  ");
  $stmt->execute([
    $_SESSION['user_id'],
    $data['mode'],
    $data['duration']
  ]);
  http_response_code(204); // sin contenido
} else {
  http_response_code(400);
}
