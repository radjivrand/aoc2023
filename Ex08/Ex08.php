<?php

namespace Aoc2023\Ex08;

use Aoc2023\Main\Exercise;

// too low: 71683294841

class Ex08 extends Exercise
{
    protected $map;
    protected $road;
    protected $dir = null;
    protected $dirIndex = null;
    protected $starts = [];
    protected $ends = [];

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        $steps = 0;

        // part 1
        // $current = 'AAA';

        // while ('ZZZ' != $current) {
        //     $this->getNextDir();
        //     $current = $this->map[$current][$this->dir];
        //     $steps ++;
        // }

        $this->getStartingPoints();
        $this->getEndIndexes();

        $currents = $this->starts;

        $res = 1;

        foreach ($currents as $val) {
            $cur = $val;
            while (!in_array($cur, $this->ends) ) {
                $this->getNextDir();
                $cur = $this->map[$cur][$this->dir];
                $steps ++;
            }

            $div = $steps / 293;

            $res *= $div;
            $this->dir = null;
            $steps = 0;
        }

        print_r($res * 293);
    }

    public function allEnded($arr)
    {
        $counter = 0;
        foreach ($arr as $value) {
            if (in_array($value, $this->ends)) {
                $counter ++;
            }
        }

        return $counter > 2;
    }

    public function getEndIndexes()
    {
        foreach ($this->map as $key => $value) {
            if (preg_match('/..Z/', $key)) {
                $this->ends[] = $key;
            }
        }
    }

    public function getStartingPoints()
    {
        foreach ($this->map as $key => $value) {
            if (preg_match('/..A/', $key)) {
                $this->starts[] = $key;
            }
        }
    }

    public function getNextDir()
    {
        $this->dirIndex = null === $this->dirIndex ? 0 : $this->dirIndex + 1;

        if ($this->dirIndex == count($this->road)) {
            $this->dirIndex = 0;
        }

        $this->dir = $this->road[$this->dirIndex];
    }

    public function parseInput($arr)
    {
        $this->road = str_split($arr[0]);

        $arr = array_slice($arr, 2);

        foreach ($arr as $row) {
            list($label, $dest) = explode(' = ', $row);
            $dest = preg_replace('/[\(|\)]/', '', $dest);
            list($left, $right) = explode(', ', $dest);

            $this->map[$label]['L'] = $left;
            $this->map[$label]['R'] = $right;
        }
    }
}
