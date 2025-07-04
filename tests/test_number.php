<?php
$a = 123;
var_dump(is_numeric($a));  // true
var_dump(ctype_digit($a)); // false

$a = '123';
var_dump(is_numeric($a));  // true
var_dump(ctype_digit($a)); // true

$a = '0123';
var_dump(is_numeric($a));  // true
var_dump(ctype_digit($a)); // true

$a = 0.123;
var_dump(is_numeric($a));  // true
var_dump(ctype_digit($a)); // false

$a = -123;
var_dump(is_numeric($a));  // true
var_dump(ctype_digit($a)); // false

$a = 'abc';
var_dump(is_numeric($a));  // false
var_dump(ctype_digit($a)); // false
