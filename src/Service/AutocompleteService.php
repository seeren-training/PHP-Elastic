<?php

namespace App\Service;


class AutocompleteService
{

    public function __construct(
        private DocumentService $documentService,
        private DocumentMapperService $documentMapperService,
    ) {
    }

    public function getResultsAndSuggests(string $search): array
    {
        $size = 5;

        $query = [
            '_source' => false,
            'fields' => ['name_search_as_you_type'],
            'size' => $size,
        ] + require __DIR__ . '/../../search/autocomplete.php';

        $response = $this->documentService->searchDocument(
            'products',
            $query
        );

        return $this->documentMapperService->mapAutocomplete(
            $response,
            $size
        );
    }



}
