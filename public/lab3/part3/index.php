<?php

header('Content-Type: application/json');
http_response_code(200);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.html');

  echo json_encode([
    "status" => "error",
    "message" => "Method not allowed. Please use POST method",
  ]);

  exit;
}

$client_ip = $_SERVER['REMOTE_ADDR'] ?? 'Not defined';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Not defined';
$current_script = $_SERVER['PHP_SELF'] ?? 'Not defined';
$request_method = $_SERVER['REQUEST_METHOD'] ?? 'Not defined';
$script_path = $_SERVER['SCRIPT_FILENAME'] ?? 'Not defined';

echo json_encode([
  "status" => "success",
  "message" => "Info received",
  "client_ip" => $client_ip,
  "user_agent" => $user_agent,
  "current_script" => $current_script,
  "request_method" => $request_method,
  "script_path" => $script_path,
]);