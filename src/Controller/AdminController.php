<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private ManagerRegistry $manager;

    private SerieRepository $serieRepository;

    public function __construct(ManagerRegistry $managerRegistry, SerieRepository $serieRepository)
    {
        $this->manager = $managerRegistry;
        $this->serieRepository = $serieRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'series' => $this->serieRepository->findBy([], ['letter' => 'asc', 'level' => 'asc', 'number' => 'asc']),
        ]);
    }
}
