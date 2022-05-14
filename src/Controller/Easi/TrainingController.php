<?php

namespace App\Controller\Easi;

use App\Entity\HistoryTraining;
use App\Entity\Training;
use App\Entity\Word;
use App\Repository\HistoryTrainingRepository;
use App\Repository\SerieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

/**
 * @Route("/eleve/training", name="training_")
 */
class TrainingController extends AbstractController
{
    private array $letters = [
        'a',
        'e',
        's',
        'i'
    ];

    /**
     * @Route("/{trainingNumber}", name="training")
     */
    public function index(int $trainingNumber, SerieRepository $serieRepository, ManagerRegistry $manager): Response
    {
        $training = new Training();
        $training->setScore(0);
        $training->setStep(0);
        $training->setErrorCount(0);
        $training->setPlayer($this->getUser());
        $series = $serieRepository->findBy(['positionTest' => $trainingNumber]);
        foreach ($series as $serie) {
            foreach ($serie->getWords() as $word) {
                $training->addWord($word);
            }
        }
        $manager->getManager()->persist($training);
        $manager->getManager()->flush();

        return $this->redirectToRoute('training_play', [
            'id' => $training->getId(),
        ]);
    }

    /**
     * @Route("/test/{id}", name="play")
     */
    public function play(
        Training $training,
        HistoryTrainingRepository $historyTrainingRepository,
        ChartBuilderInterface $chartBuilder,
        ManagerRegistry $managerRegistry
    ) {
        $words = $training->getWords();
        if (!isset($words[$training->getStep()])) {
            $letterErrors = [];
            $letterPercent = [];
            $totalErrors = count($historyTrainingRepository->findBy(['training' => $training->getId()]));
            foreach ($this->letters as $letter) {
                $letterErrors[$letter] =  count($historyTrainingRepository->findBy([
                    'training' => $training->getId(),
                    'letter' => $letter
                ]));
                $letterPercent[$letter] = 100;
                if ($totalErrors !== 0) {
                    $letterPercent[$letter] = $letterErrors[$letter] * 100 / $totalErrors;
                }
            }

            $wordsCount = [
                'a' => 0,
                'e' => 0,
                's' => 0,
                'i' => 0,
            ];
            foreach ($words as $word) {
                foreach ($this->letters as $letter) {
                    if ($word->getLetter()->getContent() === $letter) {
                        $wordsCount[$letter] ++;
                    }
                }
            }

            $resultLetter = [
                ($wordsCount['e'] - $letterErrors['e']) / $wordsCount['e'] * 100,
                ($wordsCount['a'] - $letterErrors['a']) / $wordsCount['a'] * 100,
                ($wordsCount['s'] - $letterErrors['s']) / $wordsCount['s'] * 100,
                ($wordsCount['i'] - $letterErrors['i']) / $wordsCount['i'] * 100,
            ];
            $this->getUser()->setHasTest(1);
            $managerRegistry->getManager()->flush();
            $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
            $chart->setData([
                'labels' => ['e', 'a', 's', 'i'],
                'datasets' => [
                    [
                        'label' => 'Répartition des réponses',
                        'borderRadius' => 5,
                        'backgroundColor' => [
                            'rgb(15, 175, 148, 0.5)',
                            'rgb(3, 94, 214, 0.5)',
                            'rgb(255, 213, 0, 0.5)',
                            'rgb(159, 17, 17, 0.5)',
                        ],
                        'borderWidth' => 5,
                        'borderColor' => [
                            'rgb(15, 175, 148)',
                            'rgb(3, 94, 214)',
                            'rgb(255, 213, 0)',
                            'rgb(159, 17, 17)',
                        ],
                        'data' => $resultLetter,
                    ],
                ],
            ]);
            $chart->setOptions([
                'responsive' => true,
                'aspectRatio' => 3,
                    'scales' => [
                        'y' => [
                            'grid' => [
                                'display' => false,
                            ]
                        ],
                        'x' => [
                            'ticks' => [
                                'font' => [
                                    'size' => 25,
                                    ]
                            ]
                        ]
                    ]
            ]);
            return $this->render('training/result.html.twig', [
                'game' => $training,
                'letter_errors' => $letterErrors,
                'words_count' => $wordsCount,
                'chart' => $chart,
            ]);
        }
        $word = $words[$training->getStep()];
        $letters = mb_str_split($word->getContent());
        if ($word->getStudyLetter()) {
            $position = $word->knowLetterPosition($letters);
        }
        if ($word->getMuteLetters()) {
            $muteLettersPositions = [];
            foreach ($word->getMuteLetters() as $muteLetter) {
                $muteLettersPositions[$muteLetter->getPosition() + 1] = $muteLetter->getPosition() + 1;
            }
        }
        return $this->render('easi/index.html.twig', [
            'word'          => $word,
            'game'          => $training,
            'istraining'    => true,
            'letters'       => $letters,
            'position'      => $position ?? null,
            'muteLettersPositions'  => $muteLettersPositions ?? null,
        ]);
    }

    /**
     * @Route("/{id}/mot/{word}/prononciation/{picture}", name="check_response")
     */
    public function checkResponse(
        Training $training,
        Word $word,
        string $picture,
        ManagerRegistry $managerRegistry
    ): Response {
        $manager = $managerRegistry->getManager();
        $correctPicture = $word->getPronunciation()->getPicture();
        if ($correctPicture === $picture) {
            $training->setStep($training->getStep() + 1);
            $training->setScore($training->getScore() + 1);
        } else {
            $training->setStep($training->getStep() + 1);
            $training->setErrorCount($training->getErrorCount() + 1);
            $historyTraining = new HistoryTraining();
            $historyTraining->setTraining($training);
            $historyTraining->setLetter($word->getLetter()->getContent());
            $manager->persist($historyTraining);
        }
        $manager->flush();
        return $this->redirectToRoute('training_play', [
                'id' => $training->getId(),
            ]);
    }
}
