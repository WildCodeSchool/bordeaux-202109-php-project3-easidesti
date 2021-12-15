<?php

namespace App\Controller;

use App\Entity\Letter;
use App\Entity\Word;
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
     * @Route("/{id}", name="index")
     */
    public function index(Word $word): Response
    {
        return $this->render('easi/index.html.twig', [
            'word' => $word
        ]);
    }
}
