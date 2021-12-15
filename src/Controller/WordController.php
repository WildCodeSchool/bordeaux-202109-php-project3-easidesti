<?php

namespace App\Controller;

use App\Entity\Endpoint;
use App\Entity\MuteLetter;
use App\Entity\Word;
use App\Form\WordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/word", name="word_")
 */
class WordController extends AbstractController
{
    /**
     * @Route("/ajout", name="index")
     */
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $managerRegistry->getManager();
            $endpointLetters = array_unique($request->request->get('clickedLetters'));
            foreach ($endpointLetters as $position) {
                $endpoint = new Endpoint();
                $endpoint->setPosition($position);
                $entityManager->persist($endpoint);
                $word->addEndpoint($endpoint);
            }
            $positionMuteLetters = array_unique($request->request->get('clickedMuteLetters'));
            foreach ($positionMuteLetters as $muteLetterPosition) {
                $muteLetter = new MuteLetter();
                $muteLetter->setPosition($muteLetterPosition);
                $entityManager->persist($muteLetter);
                $word->addMuteLetter($muteLetter);
            }
            $entityManager->persist($word);
            dd($word);
            $entityManager->flush();
            return $this->redirectToRoute('word_index');
        }
        return $this->renderForm('word/index.html.twig', [
            'form' => $form,
        ]);
    }
}
