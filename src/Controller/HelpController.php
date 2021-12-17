<?php

namespace App\Controller;

use App\Entity\Letter;
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

    /**
     * @Route("/{content}/aide-1", name="helpOne")
     */
    public function showHelpOne(Word $word): Response
    {
        $colors = [
            'success',
            'danger',
            'warning',
            'info',
        ];
        $letter = $word->getLetters()[0];
        $endpoints = $word->getEndpoints();
        $lenghtWord = strlen($word->getContent());
        $syllabes = [];
        for ($i = 0; $i < count($endpoints); $i++) {
            $position = 0;
            $lenght = $lenghtWord;
            if ($endpoints[$i - 1] !== null) {
                $position = $endpoints[$i]->getPosition() - 1;
            }
            if ($endpoints[$i + 1] !== null) {
                $lenght = $endpoints[$i + 1]->getPosition() - $endpoints[$i]->getPosition();
            }
            $syllabes[] = substr($word->getContent(), $position, $lenght);
        }

        return $this->render('easi/helpOne.html.twig', [
            'word' => $word,
            'letter' => $letter,
            'syllabes' => $syllabes,
            'colors' => $colors,
        ]);
    }
    /**
    * @Route("/{word_content}/{letter_content}", name="helpThree")
    * @ParamConverter("word", class="App\Entity\Word", options={"mapping": {"word_content": "content"}})
    * @ParamConverter("letter", class="App\Entity\Letter", options={"mapping": {"letter_content": "content"}})
    */
    public function showHelpThree(Letter $letter, Word $word): Response
    {
        return $this->render('easi/helpThree.html.twig', [
            'letter' => $letter,
            'word'  => $word
            ]);
    }
}
