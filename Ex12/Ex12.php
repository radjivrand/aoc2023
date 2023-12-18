<?php

namespace Aoc2023\Ex12;

use Aoc2023\Main\Exercise;

class Ex12 extends Exercise
{
    protected $lines;
    protected $scores;
    protected $secondScores;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());

        $this->run();
        // $this->runPartTwo();
    }

    public function possibilities($groups, $items)
    {
        if ($groups == 2) {
            $res = [];

            for ($i= 0; $i <= $items; $i++) {
                $pair = [$i, $items - $i];
                $res[] = $pair;
            }

            return $res;
        }

        $out = [];

        for ($i=0; $i <= $items; $i++) { 
            $res = $this->possibilities($groups - 1, $items - $i);

            foreach ($res as &$value) {
                array_unshift($value, $i);
            }

            $out = array_merge($out, $res);
        }

        return $out;
    }

    public function runPartTwo()
    {
        $res = 0;

        foreach ($this->lines as $key => $ln) {
            $pieces = array_merge($ln['pcs'], $ln['pcs']);
            $line = $ln['line'] . '?' . $ln['line'];

            $data = $this->getData($line);

            $localScore = 0;

            print_r('_________________________' . PHP_EOL);
            print_r('About to create perms for ' . (count($pieces) + 1) . ' items and ' . ($data['length'] - array_sum($pieces)) . ' spaces' . PHP_EOL);
            $perms = $this->possibilities(count($pieces) + 1, ($data['length'] - array_sum($pieces)));
            print_r('result count: ' . count($perms) . PHP_EOL);

            $perms = array_filter($perms, function($item) {
                $length = count($item);
                for ($i=1; $i < $length - 1; $i++) {
                    if ($item[$i] == 0) {
                        return false;
                    }
                }
                return true;
            });

            foreach ($perms as $perm) {
                $str = '';
                foreach ($perm as $permkey => $val) {
                    $str .= str_repeat('.', $val);
                    if (isset($pieces[$permkey])) {
                        $str .= str_repeat('#', $pieces[$permkey]);
                    }
                }

                if ($this->isValid($str, $line)) {
                    $localScore++;
                }
            }

            print_r('Line no '. $key .': local score for 2nd pass: ' . $localScore . PHP_EOL);

            $res += $localScore;
            $this->secondScores[] = $localScore;
        }

        $endRes = 0;

        foreach ($this->scores as $key => $value) {
            $multiplier = $this->secondScores[$key] / $value;
            $endRes += $value * ($multiplier ** 4);
        }

        print_r($endRes);
    }

    public function run()
    {
        $res = 0;

        foreach ($this->lines as $key => $ln) {
            $pieces = $ln['pcs'];
            $line = $ln['line'];

            $data = $this->getData($line);

            $localScore = 0;

            $perms = $this->possibilities(count($pieces) + 1, ($data['length'] - array_sum($pieces)));

            $perms = array_filter($perms, function($item) {
                $length = count($item);
                for ($i=1; $i < $length - 1; $i++) {
                    if ($item[$i] == 0) {
                        return false;
                    }
                }
                return true;
            });

            foreach ($perms as $perm) {
                $str = '';
                foreach ($perm as $permkey => $val) {
                    $str .= str_repeat('.', $val);
                    if (isset($pieces[$permkey])) {
                        $str .= str_repeat('#', $pieces[$permkey]);
                    }
                }

                if ($this->isValid($str, $line)) {
                    $localScore++;
                }
            }

            $res += $localScore;
            $this->scores[$key] = $localScore;
        }
    }

    public function getData($str)
    {
        $arr = str_split($str);
        $res = [
            '?' => 0,
            '.' => 0,
            '#' => 0,
        ];

        foreach ($arr as $key => $value) {
            $res[$value] ++;
        }

        $res['length'] = array_sum(array_values($res));

        return $res;
    }

    // a good one for partitions, might use later someday?
    public function meth($items, $groups)
    {
        if ($groups == 1) {
            return [[$items]];
        }

        $arr = [];

        for ($i=1; $i <= $items - $groups + 1; $i++) {
            $res = [$i];
            $smaller = $this->meth($items - $i, $groups - 1);

            foreach ($smaller as $combination) {
                $arr[] = array_merge($res, $combination);
            }
        }

        return $arr;
    }

    public function isValid($str, $ref)
    {
        $ref = str_split($ref);

        foreach (str_split($str) as $key => $value) {
            if ($value != $ref[$key] && $ref[$key] != '?') {
                return false;
            }
        }

        return true;
    }

    public function parseInput($arr)
    {
        foreach ($arr as $row) {
            list($line, $pieces) = explode(' ', $row);
            $pieces = explode(',', $pieces);

            $this->lines[] = [
                'line' => $line,
                'pcs' => $pieces
            ];
        }
    }
}
