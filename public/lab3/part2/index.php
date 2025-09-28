<?php
session_start();

header('Content-Type: application/json');
http_response_code(200);


if($_SERVER["REQUEST_METHOD"] === "GET") {
  if (empty($_SESSION)) {
    echo json_encode([
      "status" => "unAuthorized",
      "message" => "Session does not exist",
    ]);
  } else {
    echo json_encode([
      "status" => "success",
      "message" => "Session already set",
      "name" => $_SESSION["login"]
    ]);
  }

  exit;
} 

if($_SERVER["REQUEST_METHOD"] === "POST") {
  $login = $_POST["login"];
  $password = $_POST["password"];

  if(empty($login) || empty($password)) {
    echo json_encode([
      "status" => "error",
      "message" => "Login and password are required",
    ]);
    exit;
  }
  
  $_SESSION["login"] = $login;
  $_SESSION["password"] = $password;

  echo json_encode([
    "status" => "success",
    "message" => "Session set successfully",
    "name" => $_SESSION["login"]
  ]);

  exit;
}

if($_SERVER["REQUEST_METHOD"] === "DELETE") {
  $_SESSION = [];

  session_destroy();
  setcookie("PHPSESSID", "", time() - 1, "/");

  echo json_encode([
    "status" => "success",
    "message" => "Session destroyed successfully",
  ]);

  exit;
} 
