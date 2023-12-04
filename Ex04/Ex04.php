<?php

namespace Aoc2023\Ex04;

use Aoc2023\Main\Exercise;

class Ex04 extends Exercise
{
    protected $cards;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        $res = 0;
        // part 1
        // foreach ($this->cards as $card) {
        //     $res += $card['score'];
        // }

        // part 2
        foreach ($this->cards as $key => &$value) {
            if ($value['count'] == 0) {
                continue;
            }

            for ($i=1; $i <= $value['count']; $i++) {
                $this->cards[$i + $key]['amount'] += $value['amount'];
            }
        }

        foreach ($this->cards as $x => $y) {
            $res += $y['amount'];
        }

        print_r($res);
    }

    public function parseInput($arr)
    {
        foreach ($arr as $line) {
            list($card, $numbers) = explode(": ", $line);
            $label = trim(str_replace('Card', '', $card));

            list($winning, $choices) = explode(" | ", $numbers);
            $winning = str_replace('  ', ' ', $winning);
            $choices = str_replace('  ', ' ', $choices);
            $winning = explode(' ', $winning);
            $choices = explode(' ', $choices);

            $winning = array_map('trim', $winning);
            $choices = array_map('trim', $choices);

            $matches = array_intersect($winning, $choices);

            $this->cards[$label] = [
                'winning' => $winning,
                'choices' => $choices,
                'score' => count($matches) > 0 ? 2 ** (count($matches) - 1) : 0,
                'count' => count($matches),
                'amount' => 1
            ];
        }
    }
}
