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
        // part1
        // foreach ($this->seeds as $seed) {
        //     $res = $seed;

        //     foreach ($this->maps as $key => $map) {
        //         $res = $this->getNext($res, $map, $key);
        //     }

        //     if ($res < $this->min) {
        //         $this->min = $res;
        //     }
        // }

        // part 2
        $map = $this->maps['fertilizer-to-water'];

        // map - interval - seed??
        // print_r($this->seeds);

        $newSeeds = [];

        foreach ($this->maps as $label => $map) {
            foreach ($map as $slice) {
                foreach ($this->seeds as $seed) {
                    if ($this->areTouching($slice, $seed)) {
                        print_r($seed);
                        print_r($slice);

                        $new = $this->split($slice, $seed);

                        print_r($new);
                        print_r(PHP_EOL);
                        print_r(PHP_EOL);
                        print_r(PHP_EOL);
                    }
                }
            }
        }
    }

    public function split($slice, $seed)
    {
        // a-----slice-------b
        //       x----seed---|--y


        //       a--slice-------b
        // x-----|---seed---y


        // a-------slice---------b
        //    x--seed---y


        //    a--slice---b
        // x--|---seed---|-------y

        $sliceStart = $slice[1];
        $sliceEnd = $slice[1] + $slice[2];
        $seedStart = $seed['sta'];
        $seedEnd = $seed['end'];

        if ($sliceStart < $seedStart && $sliceEnd > $seedStart && $sliceEnd < $seedEnd) {
            return [['sta' => $seedStart, 'end' => $sliceEnd], ['sta' => $sliceEnd + 1, 'end' => $seedEnd]];
        } elseif ($sliceStart < $seedEnd && $sliceEnd > $seedEnd && $sliceStart > $seedStart) {
            return [['sta' => $seedStart, 'end' => $sliceStart], ['sta' => $sliceStart + 1, 'end' => $seedEnd]];
        } elseif ($sliceStart < $seedStart && $sliceEnd > $seedEnd) {
            return $seed;
        } elseif ($sliceStart > $seedStart && $sliceEnd < $seedEnd) {
            return [
                ['sta' => $seedStart, 'end' => $sliceStart - 1],
                ['sta' => $sliceStart, 'end' => $sliceEnd1],
                ['sta' => $sliceEnd + 1, 'end' => $seedEnd],
            ];
        }
    }

    public function areTouching($slice, $seed)
    {
        return !($seed['sta'] > $slice[1] + $slice[2] || $seed['end'] < $slice[1]);
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

        foreach ($this->maps as $key => &$map) {
            usort($map, function($a, $b) {
                return $a[1] <=> $b[1];
            });
        }

        $seedArr = [];
        foreach ($this->seeds as $key => &$seed) {
            if ($key % 2 == 1) {
                $seedArr[] = [
                    'sta' => $this->seeds[$key - 1],
                    'end' => $this->seeds[$key - 1] + $seed
                ];
            }
        }

        $this->seeds = $seedArr;
    }
}
