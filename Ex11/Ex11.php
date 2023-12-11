<?php

namespace Aoc2023\Ex11;

use Aoc2023\Main\Exercise;

class Ex11 extends Exercise
{
    protected $map;
    protected $expanded;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        $this->expand();

        $counter = 0;
        for ($i=0; $i < count($this->expanded); $i++) { 
            for ($j=$i + 1; $j < count($this->expanded); $j++) { 
                $counter += $this->getDistanceBetweenPairs($this->expanded[$i], $this->expanded[$j]);
            }
        }

        print_r($counter);
    }

    public function getDistanceBetweenPairs($a, $b)
    {
        $a = explode(':', $a);
        $b = explode(':', $b);

        return abs($a[0] - $b[0]) + abs($a[1] - $b[1]);
    }

    public function expand()
    {
        $test = [];
        foreach ($this->map as $val) {
            $test[] = explode(':', $val);
        }

        $xRef = array_unique(array_column($test, 0));
        $yRef = array_unique(array_column($test, 1));
        sort($xRef);
        sort($yRef);

        $newMap = [];
        foreach ($test as $pair) {
            $x = $pair[0];
            $xIndex = array_search($x, $xRef);
            $newX = ($xRef[$xIndex] - $xIndex) * 999999 + $x;

            $y = $pair[1];
            $yIndex = array_search($y, $yRef);
            $newY = ($yRef[$yIndex] - $yIndex) * 999999 + $y;

            $newMap[] = $newX . ':' . $newY;
        }

        $this->expanded = $newMap;
    }

    public function parseInput($arr)
    {
        $map = [];
        foreach ($arr as $rowIndex => $row) {
            $map[$rowIndex] = str_split($row);
        }

        foreach ($map as $r => $row) {
            foreach ($row as $c => $value) {
                if ($value == '#') {
                    $this->map[] = $r . ':' . $c;
                }
            }
        }
    }
}
