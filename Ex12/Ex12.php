<?php

namespace Aoc2023\Ex12;

use Aoc2023\Main\Exercise;

class Ex12 extends Exercise
{
    protected $lines;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        print_r(PHP_EOL);
        // print_r($this->lines);

        // foreach ($this->lines as $ln) {
            // print_r($this->getCurrentPcs($line['line']));
            // print_r($line['pcs']);
            $ln = $this->lines[0];

            $pieces = $ln['pcs'];
            $line = $ln['line'];

            $data = $this->getData($line);
            $reqHashtags = array_sum($pieces);
            $reqDots = strlen($line) - $reqHashtags;

            $bag = [
                '#' => $reqHashtags - $data['#'],
                '.' => $reqDots - $data['.']
            ];


            $a = 10 >> 2;

            print_r($a);
            print_r($this->meth(4,2));


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

    public function getCurrentPcs($str)
    {
        $splat = str_split($str);
        $curLen = 0;
        $res = [];
        foreach ($splat as $key => $char) {
            if (isset($splat[$key + 1])) {
                if ($char == '#') {
                    $curLen++;
                    if ($splat[$key + 1] != '#') {
                        $res[] = $curLen;
                        $curLen = 0;
                    }
                } else {
                    continue;
                }
            } else {
                if ($char == '#') {
                    $curLen++;
                    $res[] = $curLen;
                }
                return $res;
            }
        }
    }

    public function getPerms($arr)
    {
        $start = $arr['line'];
        $pcs = $arr['pcs'];

        print_r($pcs);
        print_r($start);

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
