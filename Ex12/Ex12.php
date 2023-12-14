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
        $res = 0;

        foreach ($this->lines as $ln) {
        // $ln = $this->lines[5];
            $pieces = $ln['pcs'];
            $line = $ln['line'];

            $data = $this->getData($line);
            $reqHashtags = array_sum($pieces);
            $reqDots = strlen($line) - $reqHashtags;

            $bag = [
                '#' => $reqHashtags - $data['#'],
                '.' => $reqDots - $data['.']
            ];

            $options = $this->getOptions($bag['#'], $data['?']);

            $splitLine = str_split($line);

            foreach ($options as $opt) {
                $counter = 0;
                $str = '';
                foreach ($splitLine as $char) {
                    if ($char == '?') {
                        $str .= (int)$opt[$counter] ? '#' : '.';
                        $counter++;
                    } else {
                        $str .= $char;
                    }
                }


                if ($this->isValid($str, $line) && $this->getCurrentPcs($str) == $pieces) {
                    $res++;
                }
            }
        }

        print_r($res);
    }

    public function getOptions($hashtags, $room)
    {
        $res = [];

        for ($i=0; $i < 2 ** $room; $i++) { 
            $str = str_pad(decbin($i), $room, '0', STR_PAD_LEFT);

            $arr = str_split($str);
            if (array_sum($arr) != $hashtags) {
                continue;
            }

            $res[] = $arr;
        }

        return $res;
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
