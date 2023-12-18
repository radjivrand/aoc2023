<?php

namespace Aoc2023\Ex18;

use Aoc2023\Main\Exercise;

class Ex18 extends Exercise
{
    protected $legend;

    public function __construct()
    {
        // $this->parseInput($this->getFileContents());
        $this->parseInputPartTwo($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        $cur = [0,0];
        $path = [];
        $path[] = $cur;
        foreach ($this->legend as $step) {
            for ($i=0; $i < $step['amount']; $i++) {
                switch ($step['dir']) {
                    case 'R':
                        $cur = [$cur[0],$cur[1] + 1];
                        $path[] = $cur;
                        break;
                    case 'L':
                        $cur = [$cur[0],$cur[1] - 1];
                        $path[] = $cur;
                        break;
                    case 'U':
                        $cur = [$cur[0] - 1,$cur[1]];
                        $path[] = $cur;
                        break;
                    case 'D':
                        $cur = [$cur[0] + 1,$cur[1]];
                        $path[] = $cur;
                        break;
                }
            }
        }

        $map = $this->createMap($path);
        // $this->output($map);
        $map = $this->fill($map);
        // $this->output($map);
        $counter = 0;
        foreach ($map as $row) {
            foreach ($row as $char) {
                if ($char == '#') {
                    $counter++;
                }
            }
        }

        print_r($counter);
    }

    public function fill($map)
    {
        $queue = [[1,1]];

        while (!empty($queue)) {
            $n = array_shift($queue);
            if (isset($map[$n[0]][$n[1]]) && $map[$n[0]][$n[1]] == '.') {
                $map[$n[0]][$n[1]] = '#';
                if (isset($map[$n[0] + 1][$n[1]]) && $map[$n[0] + 1][$n[1]] == '.') {
                    $queue[] = [$n[0] + 1, $n[1]];
                }
                if (isset($map[$n[0] - 1][$n[1]]) && $map[$n[0] - 1][$n[1]] == '.') {
                    $queue[] = [$n[0] - 1, $n[1]];
                }
                if (isset($map[$n[0]][$n[1] + 1]) && $map[$n[0]][$n[1] + 1] == '.') {
                    $queue[] = [$n[0], $n[1] + 1];
                }
                if (isset($map[$n[0]][$n[1] - 1]) && $map[$n[0]][$n[1] - 1] == '.') {
                    $queue[] = [$n[0], $n[1] - 1];
                }
            }
        }

        return $map;

    }

    public function output($map)
    {
        foreach ($map as $row) {
            foreach ($row as $val) {
                print_r($val);
            }
            print_r(PHP_EOL);
        }
    }

    public function createMap($arr)
    {
        $minX = $minY = INF;
        $maxX = $maxY = 0;
        foreach ($arr as $loc) {
            if ($loc[0] < $minY) {
                $minY = $loc[0];
            }
            if ($loc[0] > $maxY) {
                $maxY = $loc[0];
            }
            if ($loc[1] < $minX) {
                $minX = $loc[1];
            }
            if ($loc[1] > $maxX) {
                $maxX = $loc[1];
            }
        }

        $map = [];
        for ($i=$minY; $i <= $maxY; $i++) { 
            for ($j=$minX; $j <= $maxX; $j++) { 
                $map[$i][$j] = '.';
            }
        }

        foreach ($arr as $loc) {
            $map[$loc[0]][$loc[1]] = '#';
        }

        return $map;
    }

    public function parseInput($arr)
    {
        foreach ($arr as $line) {
            $exploded = explode(' ', $line);
            $this->legend[] = [
                'dir' => $exploded[0],
                'amount' => $exploded[1],
                'rgb' => $exploded[2],
            ];
        }
    }
    
    public function parseInputPartTwo($arr)
    {
        $dirs = ['R', 'D', 'L', 'U'];

        foreach ($arr as $line) {
            $exploded = explode(' ', $line);

            $rgb = $exploded[2];
            $rgb = preg_replace('/#|\(|\)/', '', $rgb);

            $dir = substr($rgb, -1) ;
            $hex = rtrim($rgb);

            $this->legend[] = [
                'dir' => $dirs[$dir],
                'amount' => hexdec($hex),
                'rgb' => $exploded[2],
            ];
        }
    }
}
