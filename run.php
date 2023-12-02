<?php
namespace Aoc2023;

use Aoc2023\Main\Exercise;
use Aoc2023\Ex01\Ex01;
use Aoc2023\Ex02\Ex02;

ini_set('log_errors', 1);
ini_set('memory_limit', '8G');

require_once __DIR__ . '/vendor/autoload.php';
error_reporting(-1);

Exercise::setArgs($argv[1] ?? null);

// $ex01 = new Ex01();
$ex02 = new Ex02();

