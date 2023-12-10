<?php

namespace Aoc2023\Ex10;

use Aoc2023\Main\Exercise;

class Ex10 extends Exercise
{
    protected $map;
    protected $current;
    protected $visited;

    protected $ref = [
        '-' => [
            'left' => ['F', 'L', '-'],
            'right' => ['7', 'J', '-'],
        ],
        '|' => [
            'up' => ['F', '7', '|'],
            'down' => ['L', 'J', '|'],
        ],
        'F' => [
            'down' => ['L', 'J', '|'],
            'right' => ['7', 'J', '-'],
        ],
        'L' => [
            'up' => ['F', '7', '|'],
            'right' => ['7', 'J', '-'],
        ],
        '7' => [
            'down' => ['L', 'J', '|'],
            'left' => ['F', 'L', '-'],
        ],
        'J' => [
            'up' => ['F', '7', '|'],
            'left' => ['F', 'L', '-'],
        ],
    ];

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        $new = $this->findNext();

        while (!empty($new)) {
            $new = $this->findNext();
        }

        print_r((count($this->visited) + 1) / 2);
        print_r(PHP_EOL);


        // part2 
        foreach ($this->map as $row => $line) {
            foreach ($line as $col => $value) {
                print_r(!in_array([$row, $col], $this->visited) ? '#' : ' ');
                # code...
            }
            print_r(PHP_EOL);

        }
    }

    public function findNext()
    {
        $y = $this->current[0];
        $x = $this->current[1];

        $currentChar = $this->map[$y][$x];
        $candidates = $this->ref[$currentChar];

        foreach ($candidates as $dir => $opts) {
            switch ($dir) {
                case 'up':
                    $loc = [$y - 1, $x];
                    break;
                case 'down':
                    $loc = [$y + 1, $x];
                    break;
                case 'left':
                    $loc = [$y, $x - 1];
                    break;
                case 'right':
                    $loc = [$y, $x + 1];
                    break;
            }

            if (in_array($this->map[$loc[0]][$loc[1]], $opts) && (empty($this->visited) || !in_array($loc, $this->visited))) {
                $this->visited[] = $this->current;
                $this->current = $loc;
                return $loc;
            }
        }

        return [];
    }

    public function parseInput($arr)
    {
        foreach ($arr as $key => $line) {
            if (preg_match('/S/', $line)) {
                $this->current = [$key, strpos($line, 'S')];
            }
            $this->map[$key] = str_split($line);
        }

        // part 1 test
        // if ($this->current == [2,0]) {
        //     $this->map[2][0] = 'F';
        if ($this->current == [4,12]) {
            $this->map[4][12] = 'F';
        } else {
            $this->map[72][119] = 'J';
        }
    }
}
