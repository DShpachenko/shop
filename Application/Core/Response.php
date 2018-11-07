<?php

namespace Core;

class Response
{
    public static function json($var)
    {
        echo json_encode($var);
    }
}