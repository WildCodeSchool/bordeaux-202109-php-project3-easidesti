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

    public function generateLetterPosition(array $wordLetters, string $letter, int $positionLetter): string
    {
        $datas = [];
        foreach ($wordLetters as $key => $arrLetter) {
            if ($arrLetter === $letter) {
                $datas[] = $key;
            }
        }
        $result = 0;
        for ($i = 0; $i < count($datas); $i++) {
            if ($datas[$i] === $positionLetter) {
                $result = $i + 1;
            }
        }
        return $letter . '_' . $result;
    }
}
