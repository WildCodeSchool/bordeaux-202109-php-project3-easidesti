<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapController extends AbstractController
{
    /**
     * @Route("/recap/{game}", name="recap_game")
     */
    public function showEasiRecap(Game $game): Response
    {
        $letter = $game->getWords()[0]->getLetter()->getContent();
        $word = $game->getWords()[0];
        return $this->render('recap/index.html.twig', [
            'game' => $game,
            'letter' => $letter,
            'word' => $word,
        ]);
    }
}
