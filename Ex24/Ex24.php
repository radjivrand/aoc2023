<?php

namespace Aoc2023\Ex24;

use Aoc2023\Main\Exercise;

class Ex24 extends Exercise
{
    protected $items;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        print_r($this->items);
    }

    public function findIntersect($a, $b)
    {
        $axBefore = $a['pos'][0];
        $axAfter = $a['pos'][0] + $a['vel'][0];

        $ayBefore = $a['pos'][1];
        $ayAfter = $a['pos'][1] + $a['vel'][1];

        $bxBefore = $b['pos'][0];
        $bxAfter = $b['pos'][0] + $b['vel'][0];

        $byBefore = $b['pos'][1];
        $byAfter = $b['pos'][1] + $b['vel'][1];


        $aa = $ayAfter - $ayBefore;
        $bb = $axBefore - $axAfter;
        $cc = $ayBefore * 






    }

    public function areClosing($a, $b)
    {
        $deltaXBefore = $a['pos'][0] - $a['pos'][0];
        $deltaYBefore = $a['pos'][1] - $a['pos'][1];

        $deltaXAfter = $a['pos'][0] + $a['vel'][0] - $a['pos'][0] - $a['vel'][0];
        $deltaYAfter = $a['pos'][1] + $a['vel'][1] - $a['pos'][1] - $a['vel'][1];

        return ($deltaXAfter ** 2 + $deltaYAfter ** 2) < ($deltaXBefore ** 2 + $deltaYBefore ** 2);
    }

    public function parseInput($arr)
    {
        foreach ($arr as $row) {
            list($pos, $vel) = explode(' @ ', $row);
            $pos = explode(', ', $pos);
            array_walk($pos, function(&$item) { $item = trim($item);});
            $vel = explode(', ', $vel);
            array_walk($vel, function(&$item) { $item = trim($item);});
            $this->items[] = ['pos' => $pos, 'vel' => $vel];
        }
    }
}
