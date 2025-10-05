<?php


class BankAccount implements AccountInterface {
  protected int $id;
  protected float $balance;
  public string $currency;
  protected string $type;

  public function __construct(string $currency = 'UAH', float $balance = 0, int $id = 0, string $type = 'Account') {
    $this->MIN_BALANCE($balance);
    $this->currency = $currency;
    $this->id = $id;
    $this->type = $type;
  }

  private function MIN_BALANCE(float $balance) {
    if ($balance < 0) {
      $this->balance = 0;
    } else {
      $this->balance = $balance;
    }
  }

  public function deposit(float $amount): Response {
    if ($amount <= 0) {
      return new Response(false, 'Invalid amount', $this->balance);
    } else {
      $this->balance += $amount;
      return new Response(true, 'Deposit successful', $this->balance);
    }
  }

  public function withdraw(float $amount): Response {
    if ($amount > $this->balance || $amount <= 0) {
      return new Response(false, 'Insufficient funds or invalid amount', $this->balance);
    } else {
      $this->balance -= $amount;
      return new Response(true, 'Withdrawal successful', $this->balance);
    }
  }

  public function getBalance(): float {
    return $this->balance;
  }

  public function toArray(): array {
    return [
      'id' => $this->id,
      'type' => $this->type,
      'currency' => $this->currency,
      'balance' => $this->balance,
    ];
  }

}
