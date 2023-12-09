<?php

namespace Aoc2023\Ex09;

use Aoc2023\Main\Exercise;

class Ex09 extends Exercise
{
    protected $lines;
    protected $level;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        $right = 0;
        $left = 0;

        foreach ($this->lines as $line) {
            $toAdd = 0;
            $toSub = 0;
            $newLine = $line;
            $multiplier = 1;

            while (!empty($newLine)) {
                $newLine = $this->getNewLine($newLine);
                $multiplier *= -1;
                $toAdd += end($newLine);
                $toSub += reset($newLine) * $multiplier;
            }

            $right += (end($line) + $toAdd);
            $left += (reset($line) + $toSub);
        }

        print_r($left);
    }

    public function getNewLine($arr)
    {
        $res = [];
        $zeroCounter = 0;
        for ($i=0; $i < count($arr) - 1; $i++) {
            $sum = $arr[$i + 1] - $arr [$i];
            if ($sum == 0) {
                $zeroCounter ++;
            }
            $res[] = $sum;
        }

        return $zeroCounter == count($res) ? [] : $res;
    }

    public function parseInput($arr)
    {
        foreach ($arr as $row) {
            $this->lines[] = explode(' ', $row);
        }
    }
}
