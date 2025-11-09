<?php

require_once "mysql-db-connect.php";

header('Content-Type: application/json');

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request method'
  ]);
  exit;
}

$username = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($username) || empty($email) || empty($password)) {
  echo json_encode([
      'status' => 'error',
      'message' => 'All fields are required'
  ]);
  exit;
}

$stmt = $pdo->prepare("SELECT id, email, username FROM users WHERE email = ? OR username = ?");
$stmt->execute([$email, $username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
  if ($user['email'] === $email) {
    echo json_encode([
      'status' => 'error',
      'message' => 'User with this email already exists'
    ]);
    exit;
  }

  if ($user['username'] === $username) {
    echo json_encode([
      'status' => 'error',
      'message' => 'User with this name already exists'
    ]);
    exit;
  }
}

$password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->execute([$username, $email, $password]);

$_SESSION['user'] = [
  'id' => $pdo->lastInsertId(),
  'name' => $username,
  'email' => $email
];

echo json_encode([
  'status' => 'success',
  'message' => 'User registered successfully',
  'user' => $_SESSION['user']
]);
