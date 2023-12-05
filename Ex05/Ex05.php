<?php

namespace Aoc2023\Ex05;

use Aoc2023\Main\Exercise;

class Ex05 extends Exercise
{
    protected $maps = [];
    protected $seeds;
    protected $min = 100000000000;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        foreach ($this->seeds as $seed) {
            $res = $seed;

            foreach ($this->maps as $key => $map) {
                $res = $this->getNext($res, $map, $key);
            }

            if ($res < $this->min) {
                $this->min = $res;
            }
        }

        print_r($this->min);
    }

    public function getNext($inputValue, $map, $key)
    {
        foreach ($map as $row) {
            if ($this->isInRange($inputValue, $row[1], $row[2])) {
                $diff = $inputValue - $row[1];
                return $row[0] + $diff;
            } else {
                $output = $inputValue;
            }
        }

        return $output;
    }

    public function isInRange($number, $start, $range)
    {
        return $start <= $number && $number <= $start + $range;
    }

    public function parseInput($arr)
    {
        $arr = array_filter($arr);
        $first = explode(': ', $arr[0]);
        $this->seeds = explode(' ', $first[1]);
        unset($arr[0], $arr[1]);

        foreach ($arr as $key => $value) {
            $exploded = explode(' ', $value);

            if (!is_numeric($exploded[0])) {
                $label = $exploded[0];
            } else {
                $this->maps[$label][] = $exploded;
            }
        }
    }
}
