<?php 

require_once './utils.php';

header('Content-Type: application/json');

$uploadDir = './uploads/';

if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

$fileName = $_POST['fileName'];
$text = $_POST['text'];
$baseName = pathinfo($fileName, PATHINFO_FILENAME);


$path = "./uploads/" . $baseName.'.txt';

$file = fopen($path, 'w');
fwrite($file, $text);

fclose($file);

returnData($baseName);
