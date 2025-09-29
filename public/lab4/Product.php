<?php

class Product {
    public $name;
    public $description;
    protected $price;

    public function __construct($name, $price, $description) {
      $this->name = $name;
      $this->price = max(0, $price);
      $this->description = $description;
    }

    public function getInfo() {
      return "Name: " . $this->name . "<br>Price: " . $this->price . "<br>Description: " . $this->description;
    }
}
