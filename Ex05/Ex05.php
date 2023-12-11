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
        $map = $this->maps['light-to-temperature'];
        $seeds = $this->seeds;

        print_r($this->maps);
        die();
        // print_r($seeds);

        // foreach ($this->maps as $key => $map) {
            // print_r($key . PHP_EOL);
            $newSeeds = [];
            foreach ($seeds as $seed) {
                $isTouching = false;

                foreach ($map as $interval) {
                    if ($this->isTouching($interval, $seed)) {
                        $isTouching = true;

                        $res = $this->splitter($interval, $seed);

                        print_r($res);
                        if (isset($res[0])) {
                            $newSeeds = array_merge($newSeeds, $res);
                        } else {
                            $newSeeds[] = $res; 
                        }
                    }
                }

                if (!$isTouching) {
                    $newSeeds[] = $seed;
                }
            }

            foreach ($newSeeds as &$newSeed) {
                foreach ($map as $interval) {
                    if ($this->isTouching($interval, $newSeed)) {
                        foreach ($newSeed as $key => &$value) {
                            $value += $interval['move'];
                        }
                    }                
                }
            }

            $seeds = $newSeeds;
            print_r($newSeeds);
        // }

    }

    public function isTouching($interval, $seed)
    {
        // if (!isset($seed['sta'])) {
        //     print_r(debug_backtrace()[0]['line'] );
        //     var_dump($seed);
        //     print_r("dalkfadlfajklfdasjklf" . PHP_EOL);            
        // }

        $a = $interval['from'] <= $seed['sta'] && $interval['to'] >= $seed['sta'];
        $b = $seed['sta'] <= $interval['from'] && $seed['end'] >= $interval['from'];
        return $a || $b;
    }

    public function splitter($interval, $seed)
    {
        $sliceStart = $interval['from'];
        $sliceEnd = $interval['to'];
        $seedStart = $seed['sta'];
        $seedEnd = $seed['end'];

        if ($sliceStart < $seedStart && $sliceEnd > $seedStart && $sliceEnd < $seedEnd) {
            return [
                ['sta' => $seedStart, 'end' => $sliceEnd],
                ['sta' => $sliceEnd + 1, 'end' => $seedEnd]
            ];
        } elseif ($sliceStart < $seedEnd && $sliceEnd > $seedEnd && $sliceStart > $seedStart) {
            print_r('if 2' . PHP_EOL);
            print_r($seed);
            print_r($interval);

            return [
                ['sta' => $seedStart, 'end' => $sliceStart],
                ['sta' => $sliceStart + 1, 'end' => $seedEnd]
            ];
        } elseif ($sliceStart <= $seedStart && $sliceEnd >= $seedEnd) {
            print_r('if 3' . PHP_EOL);
            return $seed;
        } elseif ($sliceStart > $seedStart && $sliceEnd < $seedEnd) {
            print_r('ever here?');
            return [
                ['sta' => $seedStart, 'end' => $sliceStart - 1],
                ['sta' => $sliceStart, 'end' => $sliceEnd],
                ['sta' => $sliceEnd + 1, 'end' => $seedEnd],
            ];
        }

        print_r($interval);
        print_r($seed);

        print_r("noresult really?" . PHP_EOL);
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
                $this->maps[$label][] = [
                    'from' => $exploded[1],
                    'to' => $exploded[1] + $exploded[2] - 1,
                    'move' => $exploded[0] - $exploded[1],
                ];
            }
        }

        foreach ($this->maps as $key => &$map) {
            usort($map, function($a, $b) {
                return $a['from'] <=> $b['from'];
            });
        }

        $seedArr = [];
        foreach ($this->seeds as $key => &$seed) {
            if ($key % 2 == 1) {
                $seedArr[] = [
                    'sta' => $this->seeds[$key - 1],
                    'end' => $this->seeds[$key - 1] + $seed - 1
                ];
            }
        }

        $this->seeds = $seedArr;
    }
}


        // a-----slice-------b
        //       x----seed---|--y


        //       a--slice-------b
        // x-----|---seed---y


        // a-------slice---------b
        //    x--seed---y


        //    a--slice---b
        // x--|---seed---|-------y

