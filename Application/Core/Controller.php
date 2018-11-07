<?php

namespace Core;

use Core\View;

class Controller
{
    protected $view;

    function __construct()
    {
        $this->view = new View();
    }
}