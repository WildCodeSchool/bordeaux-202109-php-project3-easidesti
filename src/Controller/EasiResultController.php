<?php

namespace App\Controller;

use App\Entity\Word;
use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/easi", name="easiresult_")
 */
class EasiResultController extends AbstractController
{
     /**
      * @Route("/resultat/{word}/game/{id}/{success}", defaults={"success"=false} , name="step")
      */
    public function showResultStep(Word $word, Game $game, $success): Response
    {
        return $this->render('easi/correction.html.twig', [
            'word' => $word,
            'game' => $game,
            'success' => $success,
        ]);
    }
}
