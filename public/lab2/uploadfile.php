<?php

require './utils.php';

header('Content-Type: application/json');

$uploadDir = './uploads/';
$file = $_FILES['file'];


function validateExtention (string $fileName): bool {
  $allowedExtensions = ['jpg', 'jpeg', 'png'];
  $extention = pathinfo($fileName, PATHINFO_EXTENSION);
  return in_array($extention, $allowedExtensions);
}

function validateSize (int $size, int $maxMbSize): bool {
  return $size <= $maxMbSize * 1024 * 1024;
}

function isExists(string $filePath): bool {
  return file_exists($filePath);
}

if(validateExtention($file['name']) && validateSize($file['size'], 2)) {
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  $filePath = $uploadDir . basename($file['name']);

  if (isExists($filePath)) {
    $filePath = $uploadDir . time() . "_" . basename($file['name']);

    move_uploaded_file($file['tmp_name'], $filePath);

    returnData($filePath);
  }

  if (move_uploaded_file($file['tmp_name'], $filePath)) {
    returnData($filePath);
  } else {
    returnError('Failed to move uploaded file');
  }

} else {
  returnError('File is not valid');
}
