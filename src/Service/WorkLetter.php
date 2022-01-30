<?php

namespace App\Service;

use App\Entity\HistoryTraining;
use App\Entity\Letter;
use App\Entity\Serie;
use App\Entity\Training;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

class WorkLetter
{
    public const LETTERS = [
        'e',
        'a',
        's',
        'i',
    ];
    private ObjectRepository $historyRepository;
    private ObjectRepository $serieRepository;
    private ObjectRepository $letterRepository;
    public function __construct(
        ManagerRegistry $managerRegistry
    ) {
        $this->historyRepository = $managerRegistry->getRepository(HistoryTraining::class);
        $this->serieRepository = $managerRegistry->getRepository(Serie::class);
        $this->letterRepository = $managerRegistry->getRepository(Letter::class);
    }

    public function getSerieForResultTraining(Training $training): Serie
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
        $level = $this->getLevelForLetterWork($this->getRandomLetterWork($datas), $training);
        $letter = $this->letterRepository->findOneBy(['content' => $this->getRandomLetterWork($datas)]);
        $series = $this->serieRepository->findBy(['letter' => $letter, 'level' => $level]);
        return $series[array_rand($series)];
    }

    /**
     * @param array $letters
     * @return string
     * Method that will return the letter to work
     */
    public function getRandomLetterWork(array $letters): string
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
