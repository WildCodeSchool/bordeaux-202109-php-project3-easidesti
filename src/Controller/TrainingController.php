<?php

namespace App\Controller;

use App\Entity\Training;
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
        return $this->render('training/index.html.twig', [
            'controller_name' => 'TrainingController',
        ]);
    }
}
