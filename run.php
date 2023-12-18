<?php
namespace Aoc2023;

use Aoc2023\Main\Exercise;
use Aoc2023\Ex01\Ex01;
use Aoc2023\Ex02\Ex02;
use Aoc2023\Ex03\Ex03;
use Aoc2023\Ex04\Ex04;
use Aoc2023\Ex05\Ex05;
use Aoc2023\Ex06\Ex06;
use Aoc2023\Ex07\Ex07;
use Aoc2023\Ex08\Ex08;
use Aoc2023\Ex09\Ex09;
use Aoc2023\Ex10\Ex10;
use Aoc2023\Ex11\Ex11;
use Aoc2023\Ex12\Ex12;
use Aoc2023\Ex13\Ex13;
use Aoc2023\Ex14\Ex14;
use Aoc2023\Ex15\Ex15;
use Aoc2023\Ex16\Ex16;
use Aoc2023\Ex17\Ex17;
use Aoc2023\Ex18\Ex18;
use Aoc2023\Ex19\Ex19;
use Aoc2023\Ex20\Ex20;
use Aoc2023\Ex21\Ex21;
use Aoc2023\Ex22\Ex22;
use Aoc2023\Ex23\Ex23;
use Aoc2023\Ex24\Ex24;
use Aoc2023\Ex25\Ex25;

ini_set('log_errors', 1);
ini_set('memory_limit', '8G');

require_once __DIR__ . '/vendor/autoload.php';
error_reporting(-1);

Exercise::setArgs($argv[1] ?? null);

// $ex01 = new Ex01();
// $ex02 = new Ex02();
// $ex03 = new Ex03();
// $ex04 = new Ex04();
// $ex05 = new Ex05();
// $ex06 = new Ex06();
// $ex07 = new Ex07();
// $ex08 = new Ex08();
// $ex09 = new Ex09();
// $ex10 = new Ex10();
// $ex11 = new Ex11();
$ex12 = new Ex12();
// $ex13 = new Ex13();
// $ex14 = new Ex14();
// $ex15 = new Ex15();
// $ex16 = new Ex16();
// $ex17 = new Ex17();
// $ex18 = new Ex18();
// $ex19 = new Ex19();
// $ex20 = new Ex20();
// $ex21 = new Ex21();
// $ex22 = new Ex22();
// $ex23 = new Ex23();
// $ex24 = new Ex24();
// $ex25 = new Ex25();
