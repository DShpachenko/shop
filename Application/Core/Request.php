<?php

namespace Core;

class Request
{
    public static function input()
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            return $_GET;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $_REQUEST;
        }

        throw new AppException('Не известный метод получения данных');
    }
}