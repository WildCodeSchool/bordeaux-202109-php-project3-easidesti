<?php

namespace App\Controller;

use App\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/easiresult", name="easiresult_")
 */
class EasiResultController extends AbstractController
{
     /**
      * @Route("/one/{content}", name="encouragementone")
      */
    public function showEncouragementOnePage(Word $word): Response
    {
        return $this->render('easi/encouragementOne.html.twig', [
            'word' => $word
        ]);
    }
     /**
      * @Route("/two/{content}", name="encouragementtwo")
      */
    public function showEncouragementTwoPage(Word $word): Response
    {
        return $this->render('easi/encouragementTwo.html.twig', [
            'word' => $word
        ]);
    }
    /**
     * @Route("/success/{content}", name="success")
     */
    public function showSuccessPage(Word $word): Response
    {
        return $this->render('easi/success.html.twig', [
            'word' => $word
        ]);
    }
    /**
     * @Route("/correction/{content}", name="correction")
     */
    public function showCorrectionPage(Word $word): Response
    {
        return $this->render('easi/correction.html.twig', [
            'word' => $word
        ]);
    }
}
