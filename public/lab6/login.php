<?php

require_once "mysql-db-connect.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request method'
  ]);
  exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email) || empty($password)) {
  echo json_encode([
    'status' => 'error',
    'message' => 'All fields are required'
  ]);
  exit;
}

$stmt = $pdo->prepare("SELECT id, email, username, password FROM users WHERE email = ?");
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user) {
  echo json_encode([
    'status' => 'error',
    'message' => 'User not found'
  ]);
  exit;
}

if(!password_verify($password, $user['password'])) {
  echo json_encode([
    'status' => 'error',
    'message' => 'Invalid Username or password'
  ]);
  exit;
}

$_SESSION['user'] = [
  'id' => $user['id'],
  'name' => $user['username'],
  'email' => $user['email']
];

echo json_encode([
  'status' => 'success',
  'message' => 'User logged in successfully',
  'user' => $_SESSION['user']
]);
