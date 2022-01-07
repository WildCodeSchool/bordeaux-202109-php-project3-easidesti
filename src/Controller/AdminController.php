<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SearchWordType;
use App\Repository\SerieRepository;
use App\Repository\WordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    private SerieRepository $serieRepository;

    private WordRepository $wordRepository;

    public function __construct(SerieRepository $serieRepository, WordRepository $wordRepository)
    {
        $this->serieRepository = $serieRepository;
        $this->wordRepository  = $wordRepository;
    }

    /**
     * @Route("/series", name="series")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchWordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $keyword = $form->getData()['search'];
            $words = $this->wordRepository->searchByKeyword($keyword);
            return $this->forward('App\Controller\AdminController::searchWord', [
                'words' => $words,
            ]);
        }
        return $this->renderForm('admin/series/index.html.twig', [
            'series' => $this->serieRepository->findBy([], ['letter' => 'asc', 'level' => 'asc', 'number' => 'asc']),
            'form'   => $form,
        ]);
    }

    public function searchWord($words)
    {
        return $this->renderForm('admin/series/search.html.twig', [
            'words' => $words,
        ]);
    }

    /**
     * @Route("/series/{id}", name="series_show", methods={"GET"})
     */
    public function show(Serie $serie): Response
    {
        return $this->renderForm('admin/series/show.html.twig', [
            'serie' => $serie,
        ]);
    }
}
