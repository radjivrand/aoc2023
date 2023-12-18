<?php

namespace Aoc2023\Ex17;

use Aoc2023\Main\Exercise;

class Ex17 extends Exercise
{
    protected $map;
    protected $queue = [];
    protected $visited = [];
    protected $parent = [];
    protected $start = [0,0];
    protected $end = [0,0];
    protected $shortMap;

    public function __construct()
    {
        $this->parseInput($this->getFileContents());
        $this->run();
    }

    public function run()
    {
        // $this->end = [count($this->map) - 1, count($this->map[0]) - 1];
        // print_r($this->shortMap);
        /**
         * leia kõigepealt lühima skooriga tee ja siis lisa tingimused
         * 
         */

        print_r($this->dijkstra('12:12'));

        // print_r($this->find());

    }

    public function dijkstra($source)
    {
        $distances = [];
        $previous = [];
        $queue = [];
        $unvisited = [];

        foreach ($this->shortMap as $label => $vertex) {
            $distances[$label] = INF;
            $previous[$label] = null;

            if ($vertex != $source) {
                $queue[] = $label;
            }
        }

        $distances[$source] = 0;

        while (!empty($queue)) {
            sort($queue);
            $subject = array_shift($queue);
            $neighbours = $this->findNear($subject);

            foreach ($neighbours as $neighbour) {
                $tempDistance = $distances[$subject] + $this->shortMap[$neighbour];

                if ($tempDistance < $distances[$neighbour]) {
                    $distances[$neighbour] = $tempDistance;
                    $previous[$neighbour] = $subject;
                }
            }
        }

        return [$distances, $previous];
    }

    public function findNear($label)
    {
        $splat = explode(':', $label);

        $candidates = [
            $splat[0] + 1 . ':' .  $splat[1],
            $splat[0] - 1 . ':' .  $splat[1],
            $splat[0] . ':' .  $splat[1] + 1,
            $splat[0] . ':' .  $splat[1] - 1,
        ];

        $res = [];

        foreach ($candidates as $item) {
            if (isset($this->shortMap[$item])) {
                $res[] = $item;
            }
        }

        return $res;
    }

    public function find()
    {
        $this->visited[] = $this->start;
        $adjacent = $this->findNeighbours($this->start);
        $this->queue[] = $this->start;

        while (!in_array($this->end, $this->visited)) {
            $node = array_shift($this->queue);
            $adjacent = $this->findNeighbours($node);

            $dirCounter = 0;
            foreach ($adjacent as $key => $neigh) {
                if ($neigh[0] == $node[0] && $neigh[1] == $node[1]) {
                    continue;
                }
                if (!in_array($neigh, $this->visited) && $dirCounter < 3) {
                    $address = $neigh[0] . ':' . $neigh[1];
                    $this->parent[$address] = $node;
                    $this->visited[] = $neigh;
                    $this->queue[] = $neigh;
                    $dirCounter ++;
                }
            }
        }

        $path = [];
        $score = 0;
        while ($node != $this->start) {
            $path[] = $node;
            $node = $this->parent[$node[0] . ':' . $node[1]];
            $score += $this->map[$node[0]][$node[1]];
        }

        $path[] = $this->start;
        print_r($score);
        return $path;
    }

    public function hasLastThreeParents($node)
    {
        $previousGuys = [];
        $labels = [];
        if (isset($this->parent[$node[0] . ':' . $node[1]])) {
            $prev = $this->parent[$node[0] . ':' . $node[1]];
            $labels[] = $prev[0] . ':' . $prev[1];
            $previousGuys[] = $prev;
        }

        if (isset($prev) && isset($this->parent[$prev[0] . ':' . $prev[1]])) {
            $prev = $this->parent[$prev[0] . ':' . $prev[1]];
            $labels[] = $prev[0] . ':' . $prev[1];
            $previousGuys[] = $prev;
        }

        if (isset($prev) && isset($this->parent[$prev[0] . ':' . $prev[1]])) {
            $prev = $this->parent[$prev[0] . ':' . $prev[1]];
            $labels[] = $prev[0] . ':' . $prev[1];
            $previousGuys[] = $prev;
        }

        if (count($previousGuys) < 3) {
            return false;
        }

        print_r('candidates: ' . implode(', ', array_values($labels)));

        $ys = array_column($previousGuys, 0);
        $xs = array_column($previousGuys, 1);

        if (
            ($ys[0] == $ys[1] && $ys[1] == $ys[2])
            || ($xs[0] == $xs[1] && $xs[1] == $xs[2])
        ) {
            print_r(', returns true' . PHP_EOL);
            return true;
        }

        print_r(', returns false' . PHP_EOL);
        return false;
    }

    public function findNeighbours($node)
    {
        $res = [];

        if (
            isset($this->map[$node[0] + 1][$node[1]])
        ) {
            $res[] = [$node[0] + 1, $node[1]];
        }

        if (
            isset($this->map[$node[0] - 1][$node[1]])
        ) {
            $res[] = [$node[0] - 1, $node[1]];
        }

        if (
            isset($this->map[$node[0]][$node[1] + 1])
        ) {
            $res[] = [$node[0], $node[1] + 1];
        }

        if (
            isset($this->map[$node[0]][$node[1] - 1])
        ) {
            $res[] = [$node[0], $node[1] - 1];
        }

        usort($res, function($a, $b) {
            return $this->map[$a[0]][$a[1]] <=> $this->map[$b[0]][$b[1]];
        });

        return $res;
    }

    public function parseInput($arr)
    {
        foreach ($arr as $rowkey => $row) {
            $this->map[] = str_split($row);
            foreach (str_split($row) as $colkey => $char) {
                $this->shortMap[$rowkey . ':' . $colkey] = $char;
            }
        }
    }
}
