<?php 

class SavingAccounts extends BankAccount {
  private float $interestRate;

  public function __construct(
    string $currency = 'UAH', 
    float $interestRate = 0.05, 
    int $id = 0, 
    string $type = 'SavingAccount',
    float $balance = 0
    ) {
    parent::__construct($currency, $balance, $id, $type);
    $this->interestRate = $this->getMinInterest($interestRate);
  }

  private function getMinInterest(float $interestRate): float {
    if ($interestRate < 0) {
      return 0.05;
    } else {
      return $interestRate;
    }
  }

  public function applyInterest(): Response {
    $this->balance += $this->balance * $this->interestRate;
    return new Response(true, 'Interest applied', $this->balance);
  }

  
  public function toArray(): array {
    return [
      'id' => $this->id,
      'type' => $this->type,
      'currency' => $this->currency,
      'balance' => $this->balance,
      'interestRate' => $this->interestRate,
    ];
  }

}