<?php

$config = include('Application\config\config.php');

function config($key)
{
    global $config;

    if(isset($config[$key])) {
        return $config[$key];
    } else {
        dd(['error' => 'Object not found!']);
    }
}

function dd($var, $flag = null)
{
    if(config('debug') || $flag ) {
        echo '<pre>';
        print_r($var);
        echo'</pre>';
        exit(0);
    }
}

function logging($row)
{
    if(config('logging')) {
        $file = fopen($_SERVER['DOCUMENT_ROOT'] .'/Log/Log.html', 'a');

        flock($file, LOCK_EX);
        fwrite($file, (date('d.m.Y H:i:s') . ' | ' . $row . '<br/>' . PHP_EOL));
        flock($file, LOCK_UN);
        fclose ($file);
    }
}