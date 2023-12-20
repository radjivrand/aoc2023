<?php

namespace Aoc2023\Ex19;

use Aoc2023\Main\Exercise;

class Ex19 extends Exercise
{
    protected $rules;
    protected $items;
    protected $cbs;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        $score = 0;
        foreach ($this->items as $item) {
            $res = eval($this->cbs['in']);

            while ($res != 'A' && $res != 'R') {
                $res = eval($this->cbs[$res]);;
            }

            if ($res == 'A') {
                $score += array_sum($item);
            }
        }

        print_r($score);
    }

    public function parseInput($arr)
    {
        $pause = false;
        foreach ($arr as $line) {
            if ('' == $line) {
                $pause = true;
                continue;
            }
            if (!$pause) {
                $this->rules[] = $line;
            } else {
                $this->items[] = $line;
            }
        }

        foreach ($this->items as &$item) {
            $str = preg_replace('/\{|\}/', '', $item);
            $splat = explode(',', $str);
            $item = [];
            foreach ($splat as &$elem) {
                $elem = explode('=', $elem);
                $item[$elem[0]] = $elem[1];
            }
        }

        $new = [];
        foreach ($this->rules as $rule) {
            $rule = str_replace('}', '', $rule);
            $splat = explode('{', $rule);
            $stuff = explode(',', $splat[1]);

            $str = 'if (false) {} ';
            foreach ($stuff as $cond) {
                if (preg_match('/\:/', $cond)) {
                    list($eq, $dest) = explode(':', $cond);
                    list($var, $sign, $number) = preg_split('/(<|>)/', $eq, -1, PREG_SPLIT_DELIM_CAPTURE);

                    $str .= 'else if ($item[\'' . $var . '\']' . $sign . $number . ') { return \'' . $dest . '\'; } ';
                } else {

                    $str .= ' else { return \'' . $cond . '\'; }';
                }
            }

            $this->cbs[$splat[0]] = $str;
        }
    }
}
