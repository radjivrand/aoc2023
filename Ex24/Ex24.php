<?php

namespace Aoc2023\Ex24;

use Aoc2023\Main\Exercise;

class Ex24 extends Exercise
{
    protected $map;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        print_r('ok');
    }

    public function parseInput($arr)
    {
        $this->map = $arr;
    }
}
