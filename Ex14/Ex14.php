<?php

namespace Aoc2023\Ex14;

use Aoc2023\Main\Exercise;

class Ex14 extends Exercise
{
    protected $map;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        print_r($this->run());
    }

    public function run()
    {
        $resArr = [];

        foreach (range(1, 300) as $value) {
            $this->cycleUp();
            $this->cycleLeft();
            $this->cycleDown();
            $this->cycleRight();

            $resArr[] = $this->getResult();
        }

        foreach ($resArr as $key => $value) {
            // if ($value == 68) { // test
            if ($value == 99119) {
                if (isset($previous)) {
                    $interval = $key - $previous;
                }
                $previous = $key;
            }
        }

        $goal = 1000000000 - 300;
        $goalModulo = $goal % $interval;

        print_r($resArr[$key - $interval + $goalModulo]);
    }

    public function output()
    {
        foreach ($this->map as $row) {
            print_r(implode('', $row));
            print_r(PHP_EOL);
        }
        print_r(PHP_EOL);
    }

    public function getResult()
    {
        $result = 0;

        foreach ($this->map as $index => $row) {
            $score = $this->getScore($row);
            $result += $score * (count($row) - $index);
        }

        return $result;
    }

    public function cycleRight()
    {
        foreach ($this->map as $key => &$row) {
            $row = $this->move($row, 1);
        }
    }

    public function cycleLeft()
    {
        foreach ($this->map as $key => &$row) {
            $row = $this->move($row, 0);
        }
    }

    public function cycleUp()
    {
        $tempMap = [];
        foreach (array_column($this->map, 0) as $key => $val) {
            $col = array_column($this->map, $key);
            $col = $this->move($col, 0);

            $tempMap[] = $col;
        }

        $newMap = [];
        foreach (array_column($tempMap, 0) as $index => $column) {
            $newMap[] = array_column($tempMap, $index);
        }

        $this->map = $newMap;
    }

    public function cycleDown()
    {
        $tempMap = [];
        foreach (array_column($this->map, 0) as $key => $val) {
            $col = array_column($this->map, $key);
            $col = $this->move($col, 1);

            $tempMap[] = $col;
        }

        $newMap = [];
        foreach (array_column($tempMap, 0) as $index => $column) {
            $newMap[] = array_column($tempMap, $index);
        }

        $this->map = $newMap;
    }

    public function getScore($arr)
    {
        $counter = 0;

        foreach ($arr as $key => $value) {
            $counter += $value == 'O' ? 1 : 0;
        }

        return $counter;
    }
 
    public function move($arr, $dir)
    {
        $directions = [
            ['/\.O/', 'O.'],
            ['/O\./', '.O'],
        ];

        $dir = $directions[$dir];
        $colstr = implode('', $arr);

        $continue = true;
        while ($continue) {
            $next = preg_replace($dir[0], $dir[1], $colstr);

            if ($next == $colstr) {
                $continue = false;
            }

            $colstr = $next;
        }

        return str_split($colstr);
    }

    public function parseInput($arr)
    {
        foreach ($arr as $value) {
            $this->map[] = str_split($value);
        }
    }
}
