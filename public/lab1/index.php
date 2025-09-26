<?php
// output text
echo "Hello world ";
// init string variable
$weeksStr = "weeks ";
$goBySlowly = "go by slowly";
// init integer variable
$weeks = 2;
// init float variable
$degrees = 28.5;
// init boolean variable
$isTrue = true;
// init counter variable
$counter = 0;

// init associative array with student data
$student = [
	"name" => "Kirill",
	"secondName" => "Morozov",
	"age" => 19,
	"city" => "Kharkiv",
	"group" => "IKM-223A"
];

// output text
echo $weeks . " " . $weeksStr . " in a row it's " . $degrees . " degrees outside, If it is 1, then it’s true. isTrue = " . $isTrue;



// next lines output types of variables
echo "<br>";
var_dump($weeks);
echo "<br>";
var_dump($weeksStr);
echo "<br>";
var_dump($degrees);
echo "<br>";
var_dump($isTrue);

echo "<br>";
echo "<br>";

// next lines output if the weeks is even or odd
if ($weeks % 2 === 0) {
    echo "It's even";
} else {
    echo "It's odd";
}

echo "<br>";
echo "<br>";

for ($i = 0; $i < 10; $i++) {
    $counter++;
    echo $counter;
    echo "<br>";
}

echo "right now counter is " .  $counter;

echo "<br>";
echo "<br>";


while ($counter !== 0) {
    echo $counter;
    echo "<br>";
    $counter--;
}

echo "right now counter is " .  $counter;

echo "<br>";
echo "<br>";


echo "Student name is " . $student["name"] . " " . $student["secondName"] . " and he is " . $student["age"] . " years old. He lives in " . $student["city"] . " and studies in " . $student["group"];

$student["dateOfBirth"] = "2006-01-01";

echo "<br>";
echo "<br>";

echo "Student name is " . $student["name"] . " " . $student["secondName"] . " and he is " . $student["age"] . " years old. He lives in " . $student["city"] . " and studies in " . $student["group"] . " and was born on " . $student["dateOfBirth"];




