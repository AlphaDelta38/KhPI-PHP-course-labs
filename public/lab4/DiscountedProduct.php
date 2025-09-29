<?php

require_once "Product.php";

class DiscountedProduct extends Product {
    public $discount;

    public function __construct($name, $price, $description, $discount) {
      parent::__construct($name, $price, $description);
      $this->discount = $discount;
    }

    public function getDiscountedPrice() {
      return $this->price * (1 - ( $this->discount / 100 ) );
    }

    public function getInfo() {
      return "Name: " . $this->name . "<br>Price: " . $this->getDiscountedPrice() . "<br>Description: " . $this->description . "<br>Discount: " . $this->discount . "%";
    }
}

