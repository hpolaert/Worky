<?php
use Worky\Test\ClassTest;

require_once("vendor/autoload.php");

$mouton = new ClassTest();
$hello = $mouton->hello();
print($hello);
