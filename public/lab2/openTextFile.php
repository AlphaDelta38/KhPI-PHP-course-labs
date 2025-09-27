<?php

require_once './utils.php';

header('Content-Type: application/json');

$fileName = $_GET['name'] ?? null;
$baseName = pathinfo($fileName, PATHINFO_FILENAME);

$path = "./uploads/" . $baseName.'.txt';

$file = fopen($path, 'r');

if (!$file) {
  returnError("File not found");
  exit;
}

$text = fread($file, filesize($path));
fclose($file);

returnData($text);
