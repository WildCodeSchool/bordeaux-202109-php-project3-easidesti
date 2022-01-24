<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\HelpStat;
use App\Repository\WordRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapController extends AbstractController
{
    /**
     * @Route("/recap/{game}", name="recap_game")
     */
    public function showEasiRecap(
        Game $game,
        RequestStack $requestStack,
        WordRepository $wordRepository,
        ManagerRegistry $managerRegistry
    ): Response {
        $entityManager = $managerRegistry->getManager();
        $letter = $game->getFirstWord()->getLetter()->getContent();
        $word = $game->getFirstWord();
        if ($requestStack->getSession()->get('helps')) {
            $helps = $requestStack->getSession()->get('helps');
            foreach ($helps as $help) {
                $helpStat = new HelpStat();
                $word = $wordRepository->findOneBy(['content' => explode('-', $help)[0]]);
                $helpStat->setWord($word);
                $helpStat->setHelpNumber(explode('-', $help)[1]);
                $helpStat->setGame($game);
                $entityManager->persist($helpStat);
            }
            $entityManager->flush();
        }
        return $this->render('recap/index.html.twig', [
            'game' => $game,
            'letter' => $letter,
            'word' => $word,
        ]);
    }
}
