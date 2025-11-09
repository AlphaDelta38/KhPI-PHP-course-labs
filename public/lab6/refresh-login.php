<?php

session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request method'
  ]);
  exit;
}


if(empty($_SESSION['user'])) {
  echo json_encode([
    'status' => 'error',
    'message' => 'User not logged in'
  ]);
  exit;
}

echo json_encode([
  'status' => 'success',
  'message' => 'User logged in successfully',
  'user' => $_SESSION['user']
]);