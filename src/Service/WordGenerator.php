<?php

namespace App\Service;

class WordGenerator
{
    public function generateEndpoint(string $word, array $inputs = null): array
    {
        $endpointLetters = $inputs ?? [];
        $endpointLetters[] = strlen($word) - 1;
        return array_unique($endpointLetters);
    }
}
