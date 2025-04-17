<?php

namespace App\Service;

use Psr\Http\Message\ResponseInterface;

class DocumentMapperService
{

    public function mapIds(ResponseInterface $response): array
    {
        $hits = $response['hits'];

        return [
            $hits['total']['value'],
            array_map(
                fn($hit) => $hit['_id'],
                $hits['hits']
            )
        ];

    }

}
