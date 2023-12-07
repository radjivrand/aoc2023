<?php

namespace Aoc2023\Ex07;

use Aoc2023\Main\Exercise;

class Ex07 extends Exercise
{
    protected $hands;
    protected $order = [
        'A' => 12,
        'K' => 11,
        'Q' => 10,
        'J' => 9,
        'T' => 8,
        '9' => 7,
        '8' => 6,
        '7' => 5,
        '6' => 4,
        '5' => 3,
        '4' => 2,
        '3' => 1,
        '2' => 0,
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

    public function getHandScore(string $hand)
    {
        $arr = [];
        foreach (str_split($hand) as $char) {
            if (!isset($arr[$char])) {
                $arr[$char] = 0;
            }
            $arr[$char] += 1;
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
