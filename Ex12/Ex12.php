<?php

namespace Aoc2023\Ex12;

use Aoc2023\Main\Exercise;

// part 2: 1074655979884 too low

class Ex12 extends Exercise
{
    protected $lines;
    protected $scores;
    protected $secondScores;
    protected $masterPerms = [];

    public function __construct()
    {
        $this->parseInput($this->getFileContents());

        $this->run();
        $this->runPartTwo();
    }

    public function possibilities($groups, $items, $level = 0) 
    {
        if ($groups == 2) {
            $res = [];

            $start = $level > 0 ? 1 : 0;
            for ($i= $start; $i <= $items; $i++) {
                $pair = [$i, $items - $i];
                $res[] = $pair;
            }

            return $res;
        }

        $out = [];

        $start = $level > 0 ? 1 : 0;
        $level = $level + 1;
        for ($i=$start; $i <= $items; $i++) { 
            $res = $this->possibilities($groups - 1, $items - $i, $level);

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
        $endRes = 0;

        foreach ($this->lines as $key => $ln) {
            // $pieces = $ln['pcs'];
            // $line = $ln['line'];
            $pieces = array_merge($ln['pcs'], $ln['pcs']);
            $line = $ln['line'] . '?' . $ln['line'];

            $data = $this->getData($line);

            $localScore = 0;

            print_r('_________________________' . PHP_EOL);
            // print_r([$line]);
            // print_r($data);
            // print_r($pieces);
            // print_r('About to create perms for ' . (count($pieces) + 1) . ' items and ' . ($data['length'] - array_sum($pieces)) . ' spaces' . PHP_EOL);

            $groups = count($pieces) + 1;
            $items = $data['length'] - array_sum($pieces);

            if (!isset($this->masterPerms[$groups . ':' . $items])) {
                $perms = $this->possibilities($groups, $items);
                $this->masterPerms[$groups . ':' . $items] = $perms;
            } else {
                $perms = $this->masterPerms[$groups . ':' . $items];
            }
                
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
            $this->secondScores[] = $localScore;
            $div = $localScore / $this->scores[$key];

            print_r('Line no '. $key + 1 .': local score for 2nd pass: ' . $localScore . PHP_EOL);
            print_r('Divide '. $localScore  . ' by ' .  $this->scores[$key] .' = ' . $div . PHP_EOL);

            $endRes += $this->scores[$key] * $div * $div * $div * $div;
        }

        // print_r($res);
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
