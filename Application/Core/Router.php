<?php

namespace Core;

class Router
{
    const DIVIDER = '@';

    private $routes;

    public function start()
    {
        $route = $this->findRoute();

        $controllerName = 'Controllers\\' . $route['Controller'];
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '\\Application\\' . $controllerName . '.php';

        if(file_exists($filePath)) {
            Autoloader::autoload($controllerName);
        } else {
            throw new AppException('Не найден контроллер - ' . $filePath); 
        }

        $controller = new $controllerName;

        $action = $route['Action'];

        if(method_exists($controller, $action)) {
            $controller->$action();
        } else {
            throw new AppException('Не найден указанный метод (' . $action . ') в контроллере - ' . $filePath);
        }
    }

    public function GET($url, $row)
    {
        $obj = $this->explodeRow($row);

        $this->setRoute($url, $obj, 'GET');
    }
    
    public function POST($url, $row)
    {
        $obj = $this->explodeRow($row);

        $this->setRoute($url, $obj, 'POST');
    }

    private function explodeRow($row)
    {
        if(stristr($row, self::DIVIDER) === false || $row[0] == self::DIVIDER) {
            throw new AppException('Не верное описание роута');
        }

        $explode = explode(self::DIVIDER, $row);

        if(count($explode) > 2) {
            throw new AppException('Не верное описание роута');
        }

        return [
            'Controller' => $explode[0],
            'Action'     => $explode[1]
        ];
    }

    private function setRoute($url, $obj, $type)
    {
        $this->routes[$type][$url] = [
            'Controller' => $obj['Controller'],
            'Action'     => $obj['Action'],
            'Type'       => $type,
            'URL'        => $url
        ];
    }

    private function getRoutes($type)
    {
        return $this->routes[$type];
    }

    private function getRequestURI()
    {
        $row = $_SERVER['REQUEST_URI'];

        if(stristr($row, '?')) {            
            $row = stristr($row, '?', true);
        }

        if($row != '/') {
            if($row[0] == '/')
                $row = substr($row, 1, strlen($row));

            $rowSize = strlen($row);

            if($row[$rowSize - 1] == '/')
                $row = substr($row, 0, $rowSize - 1);
        }

        return $row;
    }

    private function findRoute()
    {
        $routes = $this->getRoutes($_SERVER['REQUEST_METHOD']);

        $requestURI = $this->getRequestURI();

        if(array_key_exists($requestURI, $routes)) {
            if($routes[$requestURI]['Type'] == $_SERVER['REQUEST_METHOD']) {
                return $routes[$requestURI];
            }
        }

        throw new AppException('Не найден указанный роут - ' . $requestURI);
    }
}