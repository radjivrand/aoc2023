<?php

namespace Aoc2023\Ex15;

use Aoc2023\Main\Exercise;

// 509065 too low

class Ex15 extends Exercise
{
    protected $lines;

    public function __construct()
    {
        $this->parseInput($this->getFileContents(false));
        // $this->runPartOne();
        $this->runPartTwo();
    }


    public function runPartTwo()
    {
        $lenses = [];
        foreach ($this->lines as $line) {
            $res = preg_split('/-|=/', $line);

            $lens = [
                'label' => $res[0],
                'focal' => $res[1],
                'op' => str_contains($line, '-') ? '-' : '=',
                'box' => $this->getHashNo($res[0]),
            ];

            switch ($lens['op']) {
                case '=':
                    if (!isset($lenses[$lens['box']][$lens['label']])) {
                        $lenses[$lens['box']][$lens['label']] = $lens;
                    } else {
                        $lenses[$lens['box']][$lens['label']]['focal'] = $lens['focal'];
                    }

                    break;
                case '-':
                    if (isset($lenses[$lens['box']][$lens['label']])) {
                        unset($lenses[$lens['box']][$lens['label']]);
                    }

                    break;
            }
        }

        $res = 0;

        foreach ($lenses as $boxkey => $box) {

            $index = 1;
            foreach ($box as $lenskey => $lens) {
                $res += ($boxkey + 1) * $index * $lens['focal'];
                $index++;
            }
        }

        print_r($res);
    }

    public function runPartOne()
    {
        $res = 0;

        foreach ($this->lines as $line) {
            $res += $this->getHashNo($line);
        }

        print_r($res);
    }

    public function getHashNo($str)
    {
        $val = 0;
        $str = str_split($str);
        foreach ($str as $char) {
            $val += ord($char);
            $val = $val * 17 % 256;
        }

        return $val;
    }

    public function parseInput($arr)
    {
        $this->lines = explode(',', $arr[0]);
    }
}
