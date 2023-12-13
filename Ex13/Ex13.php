<?php

namespace Aoc2023\Ex13;

use Aoc2023\Main\Exercise;

// too high 28834

class Ex13 extends Exercise
{
    protected $maps;
    protected $lines = [];

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        // $this->runPartOne();
        print_r($this->runPartTwo());
    }

    public function runPartTwo()
    {
        foreach ($this->maps as $mp) {
            foreach ($mp as $key => $line) {
                if (isset($mp[$key + 1])) {
                    $res = $this->isAlmostMirror($key, $key + 1, $mp) * 100;

                    if ($res > 0) {
                        $sum += $res;
                        continue 2;
                    }
                }
            }

            $ver = $this->rotate($mp); 
            
            foreach ($ver as $key => $line) {
                if (isset($ver[$key + 1])) {
                    $res = $this->isAlmostMirror($key, $key + 1, $ver);

                    if ($res > 0) {
                        $sum += $res;
                        continue 2;
                    }
                }
            }
        }

        return $sum;
    }

    public function isAlmostMirror($a, $b, $map)
    {
        $len = count($map);
        $initialA = $a;
        $mistakes = 0;

        for ($i=0; $i < $len; $i++) {
            if (!isset($map[$a - $i]) || !isset($map[$b + $i])) {
                if ($mistakes == 1) {
                    return $initialA + 1;
                } else {
                    return 0;
                }
            }

            $mistakes += $this->aboutEquals($map[$a - $i], $map[$b + $i]);

            if ($mistakes > 1) {
                return 0;
            }
        }

        return 0;
    }

    public function aboutEquals($a, $b)
    {
        $b = str_split($b);
        $score = 0;

        foreach (str_split($a) as $key => $char) {
            $score += $char == $b[$key] ? 0 : 1;
        }

        return $score;
    }

    public function runPartOne()
    {
        $sum = 0;

        foreach ($this->maps as $map) {
            foreach ($map as $key => $line) {
                if (isset($map[$key + 1]) && $line == $map[$key + 1]) {
                    $res = $this->isMirror($key, $key + 1, $map) * 100;

                    if ($res != 0) {
                        $sum += $res;
                        continue 2;
                    }
                }
            }

            $ver = $this->rotate($map); 
            
            foreach ($ver as $key => $line) {
                if (isset($ver[$key + 1]) && $line == $ver[$key + 1]) {
                    $res = $this->isMirror($key, $key + 1, $ver);

                    if ($res != 0) {
                        $sum += $res;
                        continue 2;
                    }
                }
            }
        }

        print_r($sum);

    }

    public function isMirror($a, $b, $map)
    {
        $len = count($map);
        $initialA = $a;

        for ($i=0; $i < $len; $i++) {
            if (!isset($map[$a - $i]) || !isset($map[$b + $i])) {
                return $initialA + 1;
            }

            if ($map[$a - $i] != $map[$b + $i]) {
                return 0;
            }
        }
    }

    public function rotate($map)
    {
        $ver = [];
        $new = [];
        foreach ($map as $row) {
            $ver[] = str_split($row);
        }

        foreach ($ver[0] as $key => $value) {
            $new[] = implode('', array_column($ver, $key));
        }

        return $new;
    }

    public function parseInput($arr)
    {
        $new = [];
        $small = [];
        foreach ($arr as $line) {
            if ('' == $line) {
                $new[] = $small;
                $small = [];
            } else {
                $small[] = $line;
            }
        }

        $new[] = $small;

        $this->maps = $new;
    }
}
