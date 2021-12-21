<?php

namespace App\Controller;

use App\Entity\Endpoint;
use App\Entity\MuteLetter;
use App\Entity\Word;
use App\Form\WordType;
use App\Service\WordGenerator;
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
    public function index(Request $request, ManagerRegistry $managerRegistry, WordGenerator $wordGenerator): Response
    {
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $managerRegistry->getManager();
            $endpointLetters = $wordGenerator->generateEndpoint(
                $word->getContent(),
                $request->request->get('clickedLetters')
            );
            foreach ($endpointLetters as $position) {
                $endpoint = new Endpoint();
                $endpoint->setPosition($position);
                $entityManager->persist($endpoint);
                $word->addEndpoint($endpoint);
            }
            $positionMuteLetters = [];
            if ($request->request->get('clickedMuteLetters')) {
                $positionMuteLetters = array_unique($request->request->get('clickedMuteLetters'));
            }
            foreach ($positionMuteLetters as $muteLetterPosition) {
                $muteLetter = new MuteLetter();
                $muteLetter->setPosition($muteLetterPosition);
                $entityManager->persist($muteLetter);
                $word->addMuteLetter($muteLetter);
            }
            $entityManager->persist($word);
            $entityManager->flush();
            $this->addFlash('success', 'Le mot a bien été ajouté !');
            return $this->redirectToRoute('word_index');
        }
        return $this->renderForm('word/index.html.twig', [
            'form' => $form,
        ]);
    }
}
