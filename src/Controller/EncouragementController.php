<?php

namespace App\Controller;



use App\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/encouragement", name="encouragement_")
 */
class EncouragementController extends AbstractController
{
    /**
     * @Route("/one/{content}", name="encouragement")
     */
    public function showEncouragementOnePage(Word $word): Response
    {
        return $this->render('easi/encouragementOne.html.twig', [
            'word' => $word
        ]);
    }

    /**
     * @Route("/two/{content}", name="encouragement")
     */
    public function showEncouragementTwoPage(Word $word): Response
    {
        return $this->render('easi/encouragementTwo.html.twig', [
            'word' => $word
        ]);
    }
}