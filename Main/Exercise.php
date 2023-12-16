<?php

namespace Aoc2023\Main;

class Exercise
{
    const FILE_PATH = '/Users/arne/dev/';
    protected $folderPath;
    protected static $arg = null;

    public static function setArgs($arg)
    {
        self::$arg = $arg;
    }

    public function getFileContents($ignoreNewlines = true)
    {
        $exploded = explode('\\', get_called_class());
        array_pop($exploded);
        array_splice($exploded, 1, 0, 'src');
        $filePath = self::FILE_PATH . implode('/', $exploded) . '/';
        $fileName = 'input' . (self::$arg ? '_' . self::$arg : '') .  '.txt';

        if (!$ignoreNewlines) {
            return file($filePath . $fileName);
        }

        return file($filePath . $fileName, FILE_IGNORE_NEW_LINES);
    }
}
