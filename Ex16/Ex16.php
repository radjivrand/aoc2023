<?php

namespace Aoc2023\Ex16;

use Aoc2023\Main\Exercise;

//1901 too low

class Ex16 extends Exercise
{
    protected $map;
    protected $visited = [];
    protected $done = [];
    protected $beams = [
        [
            'loc' => [0,0],
            'dir' => 'S',
        ]
    ];

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        // $this->runPartOne();
        // $this->output();

        // $count = 0;
        // foreach ($this->visited as $row) {
        //     $count += count($row);
        // }
        // print_r($count);
        $this->runPartTwo();
    }

    public function runPartTwo()
    {
        $edges = $this->getEdges();
        $maxScore = 0;

        foreach ($edges as $edge) {
            $this->beams = [
                [
                    'loc' => [$edge[0], $edge[1]],
                    'dir' => $edge[2],
                ]
            ];
            $this->done = [];
            $this->visited = [];


            $counterA = 0;  
            while (!empty($this->beams)) {
                $visitCount = count($this->visited);

                $counterA++;
                $current = array_shift($this->beams);
                $this->done[] = $current;

                $counterB = 0;
                while (!empty($current) && $counterB < 500) {
                    $counterB++;
                    $this->visited[$current['loc'][0]][$current['loc'][1]] = 1;
                    $current = $this->getNext($current);
                }
            }

            $count = 0;
            foreach ($this->visited as $row) {
                $count += count($row);
            }

            if ($count > $maxScore) {
                $maxScore = $count;
            }
        }

        print_r($maxScore);
    }

    public function getEdges()
    {
        $height = count($this->map);
        $width = count($this->map[0]);

        $edges = [];

        foreach ($this->map as $rowkey => $row) {
            foreach ($row as $colkey => $char) {
                if ($rowkey == 0) {
                    $edges[] = [$rowkey, $colkey, 'S'];
                } elseif ($rowkey == $height - 1) {
                    $edges[] = [$rowkey, $colkey, 'N'];
                } elseif ($colkey == 0) {
                    $edges[] = [$rowkey, $colkey, 'E'];
                } elseif ($colkey == $width - 1) {
                    $edges[] = [$rowkey, $colkey, 'W'];
                }
            }
        }

        $edges[] = [0, 0, 'E'];
        $edges[] = [0, $width - 1, 'W'];
        $edges[] = [$width - 1, 0, 'E'];
        $edges[] = [$width - 1, $height - 1, 'W'];

        return $edges;
    }

    public function runPartOne()
    {
        $counterA = 0;
        while (!empty($this->beams)) {
            $visitCount = count($this->visited);

            $counterA++;
            $current = array_shift($this->beams);
            $this->done[] = $current;

            $counterB = 0;
            while (!empty($current) && $counterB < 500) {
                $counterB++;
                $this->visited[$current['loc'][0]][$current['loc'][1]] = 1;
                $current = $this->getNext($current);
            }
        }
    }

    public function getNext($cur)
    {
        $new = $cur;
        switch ($cur['dir']) {
            case 'E':
                $new['loc'][1]++;
                if (!isset($this->map[$cur['loc'][0]][$new['loc'][1]])) {
                    return [];
                }
                break;
            case 'W':
                $new['loc'][1]--;
                if (!isset($this->map[$cur['loc'][0]][$new['loc'][1]])) {
                    return [];
                }
                break;
            case 'N':
                $new['loc'][0]--;
                if (!isset($this->map[$new['loc'][0]][$cur['loc'][1]])) {
                    return [];
                }
                break;
            case 'S':
                $new['loc'][0]++;
                if (!isset($this->map[$new['loc'][0]][$cur['loc'][1]])) {
                    return [];
                }
                break;
        }

        switch ($this->map[$new['loc'][0]][$new['loc'][1]]) {
            case '/':
                switch ($cur['dir']) {
                    case 'E':
                        $new['dir'] = 'N';
                        break;
                    case 'W':
                        $new['dir'] = 'S';
                        break;
                    case 'N':
                        $new['dir'] = 'E';
                        break;
                    case 'S':
                        $new['dir'] = 'W';
                        break;
                }

                break;
            case '\\':
                switch ($cur['dir']) {
                    case 'E':
                        $new['dir'] = 'S';
                        break;
                    case 'W':
                        $new['dir'] = 'N';
                        break;
                    case 'N':
                        $new['dir'] = 'W';
                        break;
                    case 'S':
                        $new['dir'] = 'E';
                        break;
                }

                break;
            case '-':
                switch ($cur['dir']) {
                    case 'N':
                    case 'S':
                        $new['dir'] = 'E';
                        $other = $new;
                        $other['dir'] = 'W';

                        if (!in_array($other, $this->done)) {
                            $this->beams[] = $other;
                        }

                        break;
                }

                break;
            case '|':
                switch ($cur['dir']) {
                    case 'E':
                    case 'W':
                        $new['dir'] = 'N';
                        $other = $new;
                        $other['dir'] = 'S';

                        if (!in_array($other, $this->done)) {
                            $this->beams[] = $other;
                        }

                    break;
                }
        }

        return $new;
    }

    public function output()
    {
        foreach ($this->map as $rowkey => $row) {
            foreach ($row as $colkey => $char) {
                if (isset($this->visited[$rowkey][$colkey])) {
                    print_r('#');
                } else {
                    print_r($char);
                }
            }
            print_r(PHP_EOL);
        }
    }

    public function parseInput($arr)
    {
        foreach ($arr as $colkey => $line) {
            $this->map[] = str_split($line);
        }
    }
}
