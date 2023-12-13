<?php

namespace Aoc2023\Ex13;

use Aoc2023\Main\Exercise;

class Ex13 extends Exercise
{
    protected $maps;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
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

        for ($i=1; $i < $len; $i++) {
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
