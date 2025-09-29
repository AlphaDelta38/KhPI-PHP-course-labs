<?php

require_once "Product.php";

class Category {
    public $name;
    public $products;

    public function __construct($name) {
      $this->name = $name;
    }

    public function addProduct(Product $product) {
      $this->products[] = $product;
    }

    public function viewAllProducts() {
      foreach ($this->products as $product) {
        echo $product->getInfo() . "<br>";
        echo "<br>";
      }
    }

}