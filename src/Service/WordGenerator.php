<?php

namespace App\Service;

use App\Entity\Word;
use Doctrine\Persistence\ManagerRegistry;

class WordGenerator
{
    public ManagerRegistry $managerRegistry;
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

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

    public function cleanWordLetters(Word $word, $entityName): void
    {
        dump($word->getEndpoints());
        $allResults = $this->managerRegistry->getRepository($entityName)->findBy(['word' => $word]);
        $name = 'remove' . substr($entityName, 11);
        foreach ($allResults as $result) {
            $word->$name($result);
        }

        $this->managerRegistry->getManager()->flush();
    }
}
