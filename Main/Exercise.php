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
        $ignore = $ignoreNewlines ? FILE_IGNORE_NEW_LINES : null; 

        $exploded = explode('\\', get_called_class());
        array_pop($exploded);
        array_splice($exploded, 1, 0, 'src');
        $filePath = self::FILE_PATH . implode('/', $exploded) . '/';
        $fileName = 'input' . (self::$arg ? '_' . self::$arg : '') .  '.txt';

        return file($filePath . $fileName, $ignore);
    }
}
