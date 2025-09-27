<?php

require './utils.php';

$uploadDir = './uploads/';

if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

$files = glob('./uploads/*');
$baseUrl = 'http://127.0.0.1:8080/lab2/uploads/';

header('Content-Type: application/json');

$response = [];

foreach ($files as $file) {
  $response[] = [
    'name' => basename($file),
    'size' => filesize($file),
    'type' => mime_content_type($file),
    'link' => $baseUrl . basename($file),
  ];
}

returnData($response);
