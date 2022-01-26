<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/help", name="help")
     */
    public function showHelps(): Response
    {
        return $this->render('home/help.html.twig');
    }

    /**
     * @Route("/phoneme/game/{id}", name="phoneme")
     */
    public function showPhonemes(Game $game): Response
    {
        return $this->render('home/phoneme.html.twig', [
            'game' => $game
        ]);
    }

    /**
     * @Route("/jeux", name="jeux")
     */
    public function showGames(): Response
    {
        return $this->render('home/games.html.twig');
    }

    /**
     * @Route("/felicitation", name="congralate")
     */
    public function congrate(): Response
    {
        return $this->render('home/congrate.html.twig');
    }
}
