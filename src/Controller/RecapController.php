<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapController extends AbstractController
{
    /**
     * @Route("/recap/{game}", name="recap_game")
     */
    public function showEasiRecap(Game $game, RequestStack $requestStack): Response
    {
        $letter = $game->getFirstWord()->getLetter()->getContent();
        $word = $game->getFirstWord();
        dump($requestStack->getSession()->get('helps'));
        return $this->render('recap/index.html.twig', [
            'game' => $game,
            'letter' => $letter,
            'word' => $word,
        ]);
    }
}
