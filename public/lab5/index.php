<?php

require_once 'account-interface.php';
require_once 'BankAccount.php';
require_once 'SavingAccounts.php';

header('Content-Type: application/json');
$bankData = $_COOKIE['bankData'] ?? null;

$bankAccounts = [];
$lastIndex = 0;

if ($bankData) {
  $response = [];
  $bankData = json_decode($bankData, true);

  $accountsData = $bankData['bankAccounts'];
  $lastIndex = $bankData['lastIndex'];

  foreach ($accountsData as $account) {
    if ($account['type'] === 'SavingAccount') {
      $bankAccounts[$account['id']] = new SavingAccounts($account['currency'], $account['interestRate'], $account['id'], $account['type'], $account['balance']);
    } else {
      $bankAccounts[$account['id']] = new BankAccount($account['currency'], $account['balance'], $account['id'], $account['type']);
    }
  }


  if (($_SERVER['REQUEST_METHOD'] === 'POST') && ($_POST['action'] === 'deposit')) {
    $id = $_POST['id'];
    $amount = $_POST['amount'];

    if (isset($bankAccounts[$id])) {
      $response = $bankAccounts[$id]->deposit($amount);
    }
  }

  if (($_SERVER['REQUEST_METHOD'] === 'POST') && ($_POST['action'] === 'withdraw')) {
    $id = $_POST['id'];
    $amount = $_POST['amount'];

    if (isset($bankAccounts[$id])) {
      $response = $bankAccounts[$id]->withdraw($amount);
    }

  }

  if (($_SERVER['REQUEST_METHOD'] === 'POST') && ($_POST['action'] === 'applyInterest')) {
    $id = $_POST['id'];
    if (isset($bankAccounts[$id])) {
      $response = $bankAccounts[$id]->applyInterest();
    }
  }

  if(($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] !== 'createAccount') || $_SERVER['REQUEST_METHOD'] === 'GET'){
    $newBankAccounts = [];

    foreach ($bankAccounts as $key => $bankAccount) {
      $newBankAccounts[$key] = $bankAccount->toArray();
    }


    $newBankData = json_encode([
      'processData' => $response,
      'bankAccounts' => $newBankAccounts,
      'lastIndex' => $lastIndex,
    ]);

    setcookie('bankData', $newBankData, time() + 3600, '/');

    echo $newBankData;
    exit;
  }

}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  echo json_encode([
    'processData' => [
      'success' => true,
      'message' => 'No bank data found',
    ],
    'bankAccounts' => [],
    'lastIndex' => 0,
  ]);
  exit;
}

if (($_SERVER['REQUEST_METHOD'] === 'POST') && ($_POST['action'] === 'createAccount')) {
  $type = $_POST['type'];
  $currency = $_POST['currency'];
  $interestRate = $_POST['interestRate'];

  if ($type === 'SavingAccount') {
    $bankAccounts[$lastIndex] = new SavingAccounts($currency, $interestRate, $lastIndex, $type, 0);
  } else {
    $bankAccounts[$lastIndex] = new BankAccount($currency, 0, $lastIndex, $type);
  }

  $lastIndex++;

  $newBankAccounts = [];

  foreach ($bankAccounts as $key => $bankAccount) {
    $newBankAccounts[$key] = $bankAccount->toArray();
  }

  $newBankData = json_encode([
    'processData' => [
      'success' => true,
      'message' => 'Account created successfully',
    ],
    'bankAccounts' => $newBankAccounts,
    'lastIndex' => $lastIndex,
  ]);

  setcookie('bankData', $newBankData, time() + 3600, '/');

  echo $newBankData;
  exit;
}
