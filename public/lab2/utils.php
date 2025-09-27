<?php

function returnError(string $errorMessage) {
  http_response_code(500);

  echo json_encode([
    'error' => $errorMessage,
    'status' => 'error'
  ]);

  exit;
}

function returnData($data) {
  http_response_code(200);

  echo json_encode([
    'data' => $data,
    'status' => 'success'
  ]);

  exit;
}

?>