<?php

use Seeren\Controller\JsonController;
use Seeren\Router\Exception\MethodException;
use Seeren\Router\Exception\NotFoundException;
use Seeren\Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Router())->getResponse();
} catch (\Throwable $th) {
    $status = 500;

    if ($th instanceof NotFoundException) {
        $status = 404;
    } elseif ($th instanceof MethodException) {
        $status = 405;
    }

    (new JsonController())->render([
        'status' => $status,
        'message' => $th->getMessage(),
        'trace' => $th->getTraceAsString(),
    ]);
}
