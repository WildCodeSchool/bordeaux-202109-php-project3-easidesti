<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Word;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game_init")
     */
    public function initEasiGame(ManagerRegistry $managerRegistry): Response
    {
        $entityManager = $managerRegistry->getManager();
        $game = new Game();
        $game->setIsEasi(true);
        $game->setPlayer($this->getUser());
        $game->setstep(0);
        $game->setErrorCount(0);
        $game->setScore(0);
        $words = $entityManager->getRepository(Word::class)->findBy([], [], 7);
        foreach ($words as $word) {
            $game->addWord($word);
        }
        $entityManager->persist($game);
        $entityManager->flush();

        return $this->redirectToRoute('game_play', ['id' => $game->getId()]);
    }
    /**
     * @Route("/game/{id}", name="game_play")
     */
    public function play(Game $game): Response
    {
        $words = $game->getWords();
        $step = $game->getstep();
        $word = $words[$step];
        return $this->render('easi/index.html.twig', [
            'word' => $word,
        ]);
    }
}
