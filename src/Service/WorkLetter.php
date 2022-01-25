<?php

namespace App\Service;

use App\Entity\Training;
use App\Repository\HistoryTrainingRepository;

class WorkLetter
{
    public const LETTERS = [
        'e',
        'a',
        's',
        'i',
    ];
    public const LEVEL = [
        1 => 5,
        2 => 3,
        3 => 1,
    ];
    public HistoryTrainingRepository $historyRepository;
    public function __construct(HistoryTrainingRepository $historyTrainingRepository)
    {
        $this->historyRepository = $historyTrainingRepository;
    }

    public function getWorkLetters(Training $training): string
    {
        $datas = [];
        $totalErrors = count($this->historyRepository->findBy(['training' => $training]));
        foreach (self::LETTERS as $letter) {
            $letterCountErrors = count(
                $this->historyRepository->findBy(['training' => $training, 'letter' => $letter])
            );
            if ($letterCountErrors > 0) {
                $datas[$letter] = (int)round($letterCountErrors * 100 / $totalErrors);
            }
        }
        return $this->getLetterWork($datas);
    }

    public function getLetterWork(array $letters): string
    {
        $data = [];
        foreach ($letters as $letter => $value) {
            for ($i = 0; $i <= $value; $i++) {
                $data[] = $letter;
            }
        }
        return $data[array_rand($data)];
    }
}
