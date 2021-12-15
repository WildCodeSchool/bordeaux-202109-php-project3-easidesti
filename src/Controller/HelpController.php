<?php

namespace App\Controller;

use App\Entity\Word;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/easi/help", name="easi_")
 */
class HelpController extends AbstractController
{
    /**
     * @Route("/{id}", name="helpTwo")
     */
    public function showHelpTwo(Word $word): Response
    {
        return $this->render('easi/helpTwo.html.twig', [
            'word' => $word
        ]);
    }
}
