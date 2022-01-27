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
     * @Route("/eleve/help", name="help")
     */
    public function showHelps(): Response
    {
        return $this->render('home/help.html.twig');
    }

    /**
     * @Route("/eleve/phoneme/game/{id}", name="phoneme")
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
        if (
            in_array('ROLE_ADMIN', $this->getUser()->getRoles()) ||
            in_array('ROLE_TEACHER', $this->getUser()->getRoles())
        ) {
            return $this->redirectToRoute('admin_series');
        }
        return $this->render('home/games.html.twig');
    }

    /**
     * @Route("/eleve/felicitation", name="congralate")
     */
    public function congrate(): Response
    {
        return $this->render('home/congrate.html.twig');
    }
}
