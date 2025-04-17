<?php

namespace App\Controller;

use App\Service\AutocompleteService;
use Seeren\Controller\JsonController;
use Seeren\Router\Route\Route;

class AutocompleteController extends JsonController
{

    #[Route("/autocomplete", "GET")]
    public function autocomplete(AutocompleteService $autocompleteService)
    {
        $params = $this->getRequest()->getQueryParams();

        return $this->render(
            $autocompleteService
                ->getResultsAndSuggests((string) $params['search']),
            200
        );
    }

}
