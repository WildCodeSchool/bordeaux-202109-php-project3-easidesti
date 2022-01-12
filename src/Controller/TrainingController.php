<?php

namespace App\Controller;

use App\Entity\Training;
use App\Entity\Word;
use App\Repository\SerieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/training", name="training_")
 */

class TrainingController extends AbstractController
{
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
        $words = $training->getWords();
        $word = $words[$training->getStep()];

        return $this->render('easi/index.html.twig', [
            'word'          => $word,
            'game'          => $training,
            'istraining'    => true,
        ]);
    }

    /**
     * @Route("/{id}/mot/{word}/prononciation/{picture}", name="check_response")
     */
    public function checkResponse(Training $training, Word $word, string $picture, ManagerRegistry $managerRegistry)
    : Response
    {
        $correctPicture = $word->getPronunciation()->getPicture();
        if ($correctPicture === $picture) {
            $training->setStep($training->getStep() + 1);
            $training->setScore($training->getScore() + 1);
        }
        else {
            $training->setStep($training->getStep() + 1);
            $training->setErrorCount($training->getErrorCount() + 1);
        }
        $managerRegistry->getManager()->flush();
        return $this->redirectToRoute('training_training', [
                'trainingNumber' => $training->getId(),
            ]);
    }

}
