<?php

namespace App\Controller;

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
     * @Route("/phoneme", name="phoneme")
     */
    public function showPhonemes(): Response
    {
        return $this->render('home/phoneme.html.twig');
    }

    /**
     * @Route("/jeux", name="jeux")
     */
    public function showGames(): Response
    {
        return $this->render('home/games.html.twig');
    }
}
