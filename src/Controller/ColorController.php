<?php

namespace App\Controller;

use App\Service\ColorService;
use Seeren\Controller\JsonController;
use Seeren\Router\Route\Route;

class ColorController extends JsonController
{

    #[Route("/colors", "POST")]
    public function create(ColorService $colorService)
    {
        $payload = $this->getRequest()->getParsedBody();

        $colorService->createColor(
            $payload['name'],
            $payload['hex'],
        );

        return $this->render([], 201);
    }
}
