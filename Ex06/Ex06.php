<?php

namespace Aoc2023\Ex06;

use Aoc2023\Main\Exercise;

class Ex06 extends Exercise
{
    protected $map;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        $end = 1;
        foreach ($this->map['Time:'] as $key => $time) {
            $counter = 0;
            $toBeat = $this->map['Distance:'][$key];

            $high = $this->getMiddlePart($time);

            if (count($high) == 2) {
                for ($i=$high[1]; $i <= $time; $i++) {
                    $speed = $time - $i;
                    $res = $speed * $i;

                    if ($res > $toBeat) {
                        $counter += 2;
                    }
                }
            } else {
                for ($i=$high[0]; $i <= $time; $i++) {
                    $speed = $time - $i;
                    $res = $speed * $i;

                    if ($res > $toBeat) {
                        $counter += 2;
                    }
                }
                $counter -= 1;
            }

            $end *= $counter;
        }

        print_r($end);
    }

    public function getMiddlePart($number)
    {
        if ($number % 2 != 0) {
            return [($number - 1) / 2, (($number - 1) / 2) + 1];
        } else {
            return [$number / 2];
        }
    }

    public function parseInput($arr)
    {
        foreach ($arr as $row) {
            // part 1
            // $clean = preg_replace('/\s+/', ' ', $row);
            // $exploded = explode(' ', $clean);

            // part 2
            $clean = preg_replace('/\s+/', '', $row);
            $exploded = explode(':', $clean);

            print_r($exploded);
            $this->map[$exploded[0] . ':'] = [
                $exploded[1],
                
                // part 1
                // $exploded[2],
                // $exploded[3],
                // $exploded[4],
            ];
        }
    }
}
