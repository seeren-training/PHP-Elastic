<?php

namespace App\Controller;

use Seeren\Controller\JsonController;
use Seeren\Router\Route\Route;
use Seeren\Router\Route\RouteBuilder;

class MainController extends JsonController
{

    #[Route("/", "GET")]
    public function index(RouteBuilder $routeBuilder)
    {
        $routes = [];
        $routeBuilder->buildFromAnnotations(
            __DIR__ . '/../',
            'Controller',
            ['App\\'],
            $routes
        );
        return $this->render(array_map(fn(Route $route)  => [
            join(', ', $route->getMethods()) => $route->getPath()
        ], $routes));
    }
}
