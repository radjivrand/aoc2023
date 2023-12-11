<?php

namespace Aoc2023\Ex05;

use Aoc2023\Main\Exercise;

class Ex05 extends Exercise
{
    protected $maps = [];
    protected $seeds;
    protected $min = INF;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        // print_r($this->seeds);

        // part1
        foreach ($this->seeds as $seed) {
            $res = $seed;

            foreach ($this->maps as $key => $map) {
                $res = $this->getNext($res, $map, $key);
            }

            if ($res < $this->min) {
                $this->min = $res;
            }
        }

        // foreach ($this->seeds as $index => $seed) {
        //     if ($index % 2 == 0) {
        //         continue;
        //     }
        //     $start = $this->seeds[$index - 1];
        //     $range = $seed;

        //     // print_r('Pair ' . $index - 1 . ' and ' . $index . PHP_EOL);
        //     // print_r('Length: ' . ($start + $range) . PHP_EOL);

        //     for ($i=$start; $i < $start + $range; $i++) { 
        //         $res = $i;
        //         if ($i % 100000 == 0) {
        //             print_r('Seeds: ' . $i . PHP_EOL);

        //         }

        //         foreach ($this->maps as $key => $map) {
        //             $res = $this->getNext($res, $map, $key);
        //         }


        //         // print_r($res . PHP_EOL);
        //         if ($res < $this->min) {
        //             $this->min = $res;
        //         }
        //     }
        // }

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
