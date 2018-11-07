<?php

require_once 'Core/helpers.php';
require_once 'Core/Autoloader.php';
require_once 'Core/AppException.php';

use Core\AppException;
use Core\Autoloader;
use Core\Router;

$route = new Router();

require_once 'config/routs.php';

$route->start();