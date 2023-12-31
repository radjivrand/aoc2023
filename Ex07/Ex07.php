<?php

namespace Aoc2023\Ex07;

use Aoc2023\Main\Exercise;

class Ex07 extends Exercise
{
    // 250888060 too high
    // 250665248 just right

    protected $hands;
    protected $order = [
        'A' => 12,
        'K' => 11,
        'Q' => 10,
        'T' => 9,
        '9' => 8,
        '8' => 7,
        '7' => 6,
        '6' => 5,
        '5' => 4,
        '4' => 3,
        '3' => 2,
        '2' => 1,
        'J' => 0,
    ];

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        usort($this->hands, function($a, $b) {
            return $this->compareTwoHands($a['hand'], $b['hand']);
        });

        $score = 0;

        foreach ($this->hands as $key => $hand) {
            $score += ($key + 1) * $hand['bid'];
        }

        print_r($score);
    }

    public function compareTwoHands($a, $b)
    {
        $aScore = $this->getHandScore($a);
        $bScore = $this->getHandScore($b);

        if ($aScore != $bScore) {
            return $aScore <=> $bScore; 
        }

        $a = str_split($a);
        $b = str_split($b);

        foreach ($a as $index => $char) {
            if ($this->order[$char] > $this->order[$b[$index]]) {
                return 1;
            }

            if ($this->order[$char] < $this->order[$b[$index]]) {
                return -1;
            }
        }

        return 0;
    }

    public function getHighestRank($arr)
    {
        $score = 0;

        foreach ($arr as $key => $char) {
            if ($this->order[$char] > $score) {
                $score = $this->order[$char];
                $highest = $char;
            }
        }

        return $highest;
    }

    public function getHandScore(string $hand)
    {
        $arr = [];
        foreach (str_split($hand) as $char) {
            if (!isset($arr[$char])) {
                $arr[$char] = 0;
            }
            $arr[$char] += 1;
        }

        $chars = array_keys($arr);

        if (in_array('J', $chars)) {
            $jokers = $arr['J'];
            unset($arr['J']);

            if (empty($arr)) {
                return 100;
            }

            arsort($arr);

            if (in_array(3, $arr)) {
                $arr[array_flip($arr)[3]] += $jokers;
            }

            if (array_values($arr)[0] == 2) {
                if (isset(array_values($arr)[1]) && array_values($arr)[1] == 2) {
                    $highestChar = $this->getHighestRank([array_keys($arr)[0], array_keys($arr)[1]]);
                    $arr[$highestChar] += $jokers;
                } else {
                    $arr[array_keys($arr)[0]] += $jokers;
                }
            }

            if (array_values($arr)[0] == 1) {
                $highest = $this->getHighestRank(array_keys($arr));
                $arr[$highest] += $jokers;
            }
        }
    
        switch (count($arr)) {
            case 1:
                return 100;
            case 2:
                return (array_values($arr)[0] === 1 || array_values($arr)[0] === 4) ? 50 : 40;
            case 3:
                return (array_values($arr)[0] === 2 || array_values($arr)[1] === 2) ? 20 : 30;
            case 4:
                return 10;
            default:
                return 0;
        }
    }

    public function parseInput($arr)
    {
        foreach ($arr as $row) {
            list($hand, $bid) = explode(' ', $row);
            $this->hands[] = ['hand' => $hand, 'bid' => $bid];
        }
    }
}
