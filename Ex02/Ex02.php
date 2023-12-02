<?php

namespace Aoc2023\Ex02;

use Aoc2023\Main\Exercise;

/**
 * 
 */
class Ex02 extends Exercise
{
    protected $games = [];
    protected $ref = [
        'red' => 12,
        'green' => 13,
        'blue' => 14,
    ];

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->parseInput($inputArr);
        $this->run();
    }

    public function run()
    {
        $res = 0;

        // part 1
        // foreach ($this->games as $index => $game) {
        //     foreach ($game as $set) {
        //         foreach ($set as $color => $value) {
        //             if ($value > $this->ref[$color]) {
        //                 continue 3;
        //             }
        //         }
        //     }

        //     $res += $index;
        // }

        // part 2
        foreach ($this->games as $index => $game) {
            $red = 0;
            $green = 0;
            $blue = 0;

            foreach ($game as $set) {
                foreach ($set as $color => $value) {
                    if ($value > $$color) {
                        $$color = $value;
                    }
                }
            }

            $res += $red * $green * $blue;
        }

        print_r($res);
    }

    public function parseInput($arr)
    {
        $games = [];
        foreach ($arr as $line) {
            list($label, $contents) = explode(': ', $line);
            $contents = explode('; ', $contents);

            foreach ($contents as $setNo => &$attempt) {
                $attempt = explode(', ', $attempt);
                foreach ($attempt as &$set) {
                    list($amount, $color) = explode(' ', $set);
                    $games[explode(' ', $label)[1]][$setNo][$color] = $amount;
                }
            }

            $this->games = $games;
        }
    }
}
