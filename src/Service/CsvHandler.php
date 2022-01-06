<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Exception;

class CsvHandler
{
    public const PATH = '/src/DataFixtures/csv/';

    public function buildData(): array
    {
        $files = $this->getAllFileNames();
        $words = $this->getWords($files);
        return $words;
    }

    public function getAllFileNames(): array
    {
        $fileNames = scandir(realpath('./') . self::PATH);
        unset($fileNames[0]);
        unset($fileNames[1]);
        $result = [];
        foreach ($fileNames as $fileName) {
            $filePath = realpath('./') . self::PATH . $fileName;
            if (pathinfo($filePath)['extension'] !== 'csv') {
                throw new Exception('Files in csv directory have to be csv files');
            }
            //TODO Ajouter une regex pour vérifier que le fichier est composé d'une lettre suivi d'un chiffre
            $result[] = realpath('./') . self::PATH .$fileName;
        }
        return $result;
    }

    public function getWords(array $files): array
    {
        $result = [];
        foreach ($files as $file) {
            $result[pathinfo($file)['filename']] = $this->buildArrayFromCsv($file);
        }
        return $result;
    }

    private function buildArrayFromCsv(string $file): array
    {
        $normalizers = [new ObjectNormalizer()];
        $encoders    = [new CsvEncoder()];
        $serializer  = new Serializer($normalizers, $encoders);
        $csvToArray = $serializer->decode(file_get_contents($file), 'csv');
        $result = [];
        $serie  = '';
        foreach ($csvToArray as $inputs) {
            $inputs = array_values($inputs);
            $wordInput = $inputs[0];
            if ($wordInput !== '' && $wordInput !== null) {
                //Keep space after 'série' to prevent new serie with the word 'série'
                if (strstr($wordInput, 'série ')) {
                    $serie = trim($wordInput);
                } else {
                    $result[$serie][] = $wordInput;
                }
            }
        }
        return $result;
    }
}
