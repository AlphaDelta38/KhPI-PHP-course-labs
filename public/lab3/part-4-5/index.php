<?php
session_start();

header('Content-Type: application/json');
http_response_code(200);

$timeout = 300; 

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    exit;
}

function getProducts() {
  $sessionProducts = $_SESSION['cart'] ?? [];

  if (empty($sessionProducts)) {
    $sessionProducts = $_COOKIE['cart'] ?? [];
    $_SESSION['cart'] = $sessionProducts;
  }

  return $sessionProducts;
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $_SESSION['last_activity'] = time();

  $products = getProducts();

  echo json_encode([
    "status" => "success",
    "products" => $products,
  ]);

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $_SESSION['last_activity'] = time();

  $products = getProducts();
  $product = $_POST['product'];
  $productId = $product['id'];

  if (isset($products[$productId])) {
    $products[$productId]['size'] += $product['size'];
  } else {
    $products[$productId] = [
      "id" => $product['id'],
      "name" => $product['name'],
      "price" => $product['price'],
      "size" => $product['size'],
    ];
  }
  
  $_SESSION['cart'] = $products;

  echo json_encode([
    "status" => "success",
    "message" => "Product added to cart",
    "data" => $_SESSION['cart'],
  ]);

  setcookie('cart', json_encode($_SESSION['cart']), time() + 3600 * 24 * 7, '/');
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  $_SESSION['last_activity'] = time();

  $productId = (int)($_GET['id'] ?? 0);
  $products = getProducts();
  
  if (isset($products[$productId])) {
    if ($products[$productId]['size'] > 1) {
      $products[$productId]['size']--;
    } else {
      unset($products[$productId]);
    }
  }

  $_SESSION['cart'] = $products;

  echo json_encode([
    "status" => "success",
    "message" => "Product removed from cart",
  ]);

  setcookie('cart', json_encode($_SESSION['cart']), time() + 3600 * 24 * 7, '/');
}
