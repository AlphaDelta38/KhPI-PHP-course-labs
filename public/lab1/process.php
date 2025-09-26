<?php 


function isSomeEmpty(array $values): bool {
  foreach ($values as $value) {
      if (empty($value)) {
          return true;
      }
  }
  return false;
}

function isAllHaveType(array $values, string $type): bool {
  foreach ($values as $value) {
      if (gettype($value) !== $type) {
          return false;
      }
  }
  return true;
}

function validationMiddleWare(array $values, string $type): bool {
  if (isSomeEmpty($values)) return false;
  if (!isAllHaveType($values, $type)) return false;

  return true;
}


$name = $_POST['name'];
$secondName = $_POST['secondName'];

if (validationMiddleWare([$name, $secondName], 'string')) {
  echo "Hello, " . htmlspecialchars($name) . " " . htmlspecialchars($secondName);
} else {
  header('Location: ./index.html');
  exit;
}
