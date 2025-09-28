<?php

header('Content-Type: application/json');
http_response_code(200);

if($_SERVER["REQUEST_METHOD"] === "DELETE") {
  setcookie("username", "", time() - 1, "/");

  echo json_encode([
    "status" => "success",
    "message" => "Cookie deleted successfully",
    "name" => "User"
  ]);
  exit;
}

if(isset($_COOKIE["username"])) {
  echo json_encode([
    "status" => "success",
    "message" => "Cookie already set",
    "name" => $_COOKIE["username"]
  ]);
  exit;
}

if($_SERVER["REQUEST_METHOD"] === "GET") {
  echo json_encode([
    "status" => "success",
    "message" => "Cookie does not exist",
    "name" => "User"
  ]);
  exit;
};

$name = $_POST["name"];

setcookie("username", $name, time() + 3600 * 24 * 7, "/");

echo json_encode([
  "status" => "success",
  "message" => "Cookie set successfully",
  "name" => $name
]);
