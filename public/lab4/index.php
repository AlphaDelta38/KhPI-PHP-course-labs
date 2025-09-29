<?php

require_once "Product.php";
require_once "DiscountedProduct.php";
require_once "Category.php";

$product1 = new Product("Product 1", 100, "Description 1");
$product2 = new Product("Product 2", 100, "Description 2");
$product3 = new Product("Product 3", 100, "Description 3");

$discountedProduct1 = new DiscountedProduct("Product 1", 100, "Description 1", 10);
$discountedProduct2 = new DiscountedProduct("Product 2", 100, "Description 2", 10);
$discountedProduct3 = new DiscountedProduct("Product 3", 100, "Description 3", 10);

echo $product1->getInfo() . "<br>";
echo "<br>";
echo $product2->getInfo() . "<br>";
echo "<br>";
echo $product3->getInfo() . "<br>";
echo "<br>";

echo $discountedProduct1->getInfo() . "<br>";
echo "<br>";
echo $discountedProduct2->getInfo() . "<br>";
echo "<br>";
echo $discountedProduct3->getInfo() . "<br>";

echo "<br>";
echo "<br>";
echo "<br>";

$category1 = new Category("Category 1");

echo $category1->name . "<br>";
echo "<br>";


$category1->addProduct($product1);
$category1->addProduct($product2);
$category1->addProduct($product3);

$category1->addProduct($discountedProduct1);
$category1->addProduct($discountedProduct2);
$category1->addProduct($discountedProduct3);

$category1->viewAllProducts();

echo "<br>";
echo "<br>";
