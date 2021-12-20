<?php

namespace App\Controller;

use App\Entity\Word;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/success", name="success_")
 */
class SuccessController extends AbstractController
{
    /**
     * @Route("/{content}", name="word")
     */
    public function showSuccessPage(Word $word): Response
    {
        return $this->render('easi/success.html.twig', [
            'word' => $word
        ]);
    }
}
