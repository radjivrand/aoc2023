<?php

namespace Aoc2023\Ex03;

use Aoc2023\Main\Exercise;

class Ex03 extends Exercise
{
    protected $map;
    protected $addresses;
    protected $res;
    protected $ref;
    protected $resVolTwo;

    // 306864 too low
    // 519922 too low

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->parseInput($inputArr);
        $this->run();
        print_r($this->res);
        print_r(PHP_EOL);
        print_r($this->resVolTwo);
    }

    public function run()
    {
        foreach ($this->map as $rkey => $row) {
            $numberString = '';
            $numberStringAddress = [];
            foreach ($row as $ckey => $place) {
                if (is_numeric($place)) {
                    $numberString .= $place;
                    $numberStringAddress[] = [$rkey, $ckey];
                } else {
                    if ('' !== $numberString) {
                        $this->addresses[] = array_merge($numberStringAddress, ['value' => $numberString]);
                        $numberString = '';
                        $numberStringAddress = [];
                    }                
                    continue;
                }
            }
        }

        foreach ($this->addresses as $value => $coords) {
            foreach ($coords as $coord) {
                $found = false;

                if (is_array($coord)) {
                    if ($this->hasCharNear($coord)) {
                        $found = true;
                        $this->res += $coords['value'];
                        continue 2;         
                    }
                }
            }
        }

        // part2
        $this->createRef();

        foreach ($this->map as $rkey => $row) {
            foreach ($row as $ckey => $place) {
                if ($place == '*') {
                    $this->resVolTwo += $this->hasNumberNear([$rkey, $ckey]);
                }
            }
        }
    }

    public function createRef()
    {
        foreach ($this->addresses as $locations) {
            foreach ($locations as $loc) {
                if (is_array($loc)) {
                    $this->ref[$loc[0] . ':' . $loc[1]] = $locations['value'];
                }
            }
        }
    }

    public function hasCharNear(array $coords)
    {
        for ($i = $coords[0] - 1; $i <= $coords[0] + 1; $i++) { 
            for ($j = $coords[1] - 1; $j <= $coords[1] + 1; $j++) {
                if (isset($this->map[$i][$j]) && !preg_match('/[0-9]|\./', $this->map[$i][$j])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function hasNumberNear(array $coords)
    {
        $nearby = [];
        for ($i = $coords[0] - 1; $i <= $coords[0] + 1; $i++) { 
            for ($j = $coords[1] - 1; $j <= $coords[1] + 1; $j++) {
                if (isset($this->ref[$i . ':' . $j])) {
                    $nearby[] = $this->ref[$i . ':' . $j];
                }
            }
        }

        $nearby = array_values(array_unique($nearby));

        if (count($nearby) == 2) {
            return $nearby[0] * $nearby[1];
        }

        return 0;
    }

    public function parseInput($arr)
    {
        foreach ($arr as $rowKey => $row) {
            $places = str_split($row);
            $this->map[$rowKey] = $places;
        }

        return $this->map;
    }
}
