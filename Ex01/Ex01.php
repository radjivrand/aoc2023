<?php

namespace Aoc2023\Ex01;

use Aoc2023\Main\Exercise;

/**
 * 
 */
class Ex01 extends Exercise
{
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        $ref = [
            'one' => 1,
            'two' => 2,
            'three' => 3,
            'four' => 4,
            'five' => 5,
            'six' => 6,
            'seven' => 7,
            'eight' => 8,
            'nine' => 9,
        ];

        $res = 0;

        foreach ($arr as $bigIndex => $str) {
            $smallNoPos = null;
            $smallNo = null;
            $bigNoPos = null;
            $bigNo = null;
            $smallRefPos = null;
            $smallRef = null;
            $bigRefPos = null;
            $bigRef = null;

            foreach (array_keys($ref) as $literal) {
                $pos = strpos($str, $literal);
                if (false !== $pos) {
                    if (null === $smallRefPos || $pos < $smallRefPos) {
                        $smallRefPos = $pos;
                        $smallRef = $literal;
                    }
                }

                $rpos = strrpos($str, $literal);
                if (false !== $rpos) {
                    if (null === $bigRefPos || $rpos > $bigRefPos) {
                        $bigRefPos = $rpos;
                        $bigRef = $literal;
                    }
                }
            }

            foreach (str_split($str) as $index => $char) {
                if (is_numeric($char)) {
                    if (null === $smallNoPos) {
                        $smallNoPos = $index;
                        $smallNo = $char;
                    }

                    $bigNoPos = $index;
                    $bigNo = $char;
                }
            }


            if (!is_null($smallRef) && $smallRefPos < $smallNoPos ) {
                $first = $ref[$smallRef];
            } else {
                $first = $smallNo;
            }

            if (!is_null($bigRef) && $bigRefPos > $bigNoPos ) {
                $last = $ref[$bigRef];
            } else {
                $last = $bigNo;
            }

            print_r($str . PHP_EOL);
            print_r($first . PHP_EOL);
            print_r($last . PHP_EOL);

            $res += (int)($first . $last);
        }

        return $res;
    }
}
