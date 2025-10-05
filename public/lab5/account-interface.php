<?php

class Response {
  public function __construct(
      public bool $success,
      public string $message,
      public float $balance
  ) {}
}

interface AccountInterface {
  public function deposit(float $amount): Response;
  public function withdraw(float $amount): Response;
  public function getBalance(): float;
  public function toArray(): array;
}

