<?php

namespace App\Controller;

use App\Entity\Letter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/easi", name="easi_")
 */
class EasiController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $letterRepository = $managerRegistry->getRepository(Letter::class);
        $letters = $letterRepository->findAll();
        return $this->render('easi/index.html.twig', [
            'letters' => $letters,
        ]);
    }
}
