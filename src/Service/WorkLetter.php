<?php

namespace App\Service;

use App\Entity\Serie;
use App\Entity\Training;
use App\Repository\HistoryTrainingRepository;
use App\Repository\LetterRepository;
use App\Repository\SerieRepository;

class WorkLetter
{
    public const LETTERS = [
        'e',
        'a',
        's',
        'i',
    ];
    public HistoryTrainingRepository $historyRepository;
    public SerieRepository $serieRepository;
    public LetterRepository $letterRepository;
    public function __construct(
        HistoryTrainingRepository $historyTrainingRepository,
        SerieRepository $serieRepository,
        LetterRepository $letterRepository
    ) {
        $this->historyRepository = $historyTrainingRepository;
        $this->serieRepository = $serieRepository;
        $this->letterRepository = $letterRepository;
    }

    public function getWorkLetters(Training $training): Serie
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
        $level = $this->getLevelForLetterWork($this->getLetterWork($datas), $training);
        $letter = $this->letterRepository->findOneBy(['content' => $this->getLetterWork($datas)]);
        $series = $this->serieRepository->findBy(['letter' => $letter, 'level' => $level]);
        return $series[array_rand($series)];
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

    public function getLevelForLetterWork(string $letter, Training $training): int
    {
        $letterCountErrors = count(
            $this->historyRepository->findBy(['training' => $training, 'letter' => $letter])
        );
        if ($letterCountErrors === 1) {
            $level = 3;
        } elseif ($letterCountErrors === 2 || $letterCountErrors === 3) {
            $level = 2;
        } else {
            $level = 1;
        }

        return $level;
    }
}
