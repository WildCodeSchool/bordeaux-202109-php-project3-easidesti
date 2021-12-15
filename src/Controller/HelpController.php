<?php

namespace App\Controller;

use App\Entity\Word;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/easi/help", name="easi_")
 */
class HelpController extends AbstractController
{
    /**
     * @Route("/{word_content}", name="helpTwo")
     * @ParamConverter("word", class="App\Entity\Word", options={"mapping": {"word_content": "content"}})
     */
    public function showHelpTwo(Word $word): Response
    {
        return $this->render('easi/helpTwo.html.twig', [
            'word' => $word
        ]);
    }
}
