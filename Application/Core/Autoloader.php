<?php

namespace Core;

class Autoloader
{
    const APP_DIR = 'Application';

    public static function autoload(string $name)
    {
        $name = self::parseName($name);

        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . self::APP_DIR . '/' . $name . '.php';

        self::checkFile($filePath);

        require_once($filePath);
    }

    private static function parseName(string $row) : string
    {
        return str_replace('\\', '/', $row);
    }

    private static function checkFile($filePath)
    {
        if(!file_exists($filePath)) {
            $notify = 'The specified file could not be found - ' . $filePath;

            throw new AppException($notify);
        }
    }
}

\spl_autoload_register('Core\Autoloader::autoload');