<?php

namespace App\Controller;

use App\Entity\Letter;
use App\Entity\Word;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/easi", name="easi_")
 */
class EasiController extends AbstractController
{
    /**
     * @Route("/{word_content}", name="index")
     * @ParamConverter("word", class="App\Entity\Word", options={"mapping": {"word_content": "content"}})
     */
    public function index(Word $word): Response
    {
        return $this->render('easi/index.html.twig', [
            'word'   => $word,
        ]);
    }
}
