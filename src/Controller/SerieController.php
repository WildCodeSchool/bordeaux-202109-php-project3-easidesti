<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\LetterRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/serie", name="serie_")
 */
class SerieController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SerieRepository $serieRepository, LetterRepository $letterRepository): Response
    {
        return $this->render('serie/index.html.twig', [
            'series' => $serieRepository->findBy([], ['level' => 'ASC', 'number' => 'ASC']),
            'letters' => $letterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/show/{serie}", name="show")
     */
    public function show(Serie $serie): Response
    {
        return $this->render('serie/show.html.twig', [
            'serie' => $serie,
        ]);
    }
}
