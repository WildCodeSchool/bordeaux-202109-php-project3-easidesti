<?php

namespace App\Controller;

use App\Entity\Endpoint;
use App\Entity\MuteLetter;
use App\Entity\Word;
use App\Form\WordType;
use App\Repository\LetterRepository;
use App\Repository\SerieRepository;
use App\Repository\StudyLetterRepository;
use App\Service\WordGenerator;
use App\Service\Definition;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mot", name="word_")
 */
class WordController extends AbstractController
{
    /**
     * @Route("/ajout", name="new")
     */
    public function index(
        Request $request,
        ManagerRegistry $managerRegistry,
        WordGenerator $wordGenerator,
        SerieRepository $serieRepository,
        LetterRepository $letterRepository,
        StudyLetterRepository $studyLetterRepository
    ): Response {
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $letterData = $request->request->get('clickedLetterStudy')[0];
            if (count($request->request->get('clickedLetterStudy')) > 1) {
                $this->addFlash('danger', 'Vous devez rentrer qu\'une seule lettre');
                return $this->redirectToRoute('word_new');
            }
            $letter = $letterRepository->findOneBy(['content' => substr($letterData, 2)]);
            $positionLetter = (int)substr($letterData, 0, 1);
            $linkPosition = $wordGenerator->generateLetterPosition(
                str_split($word->getContent()),
                $letter->getContent(),
                $positionLetter
            );
            $studyLetter = $studyLetterRepository->findOneBy(['audio' => $linkPosition]);
            $word->setLetter($letter);
            $word->setStudyLetter($studyLetter);
            $serie = $serieRepository->findOneBy(['id' => $request->request->get('word')['level']]);
            $word->setSerie($serie);
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
            dd($word->getStudyLetter());
            $entityManager->persist($word);
            $entityManager->flush();
            $this->addFlash('success', 'Le mot a bien été ajouté !');
            return $this->redirectToRoute('word_new');
        }
        return $this->renderForm('admin/word/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/definition/{word}", name="definition")
     */
    public function definition(Definition $definition, string $word): Response
    {
        $definition = $definition->generateDefinition($word);
        return new JsonResponse($definition);
    }

    /**
     * @Route("/editer/{word}", name="edit")
     */
    public function update(
        Word $word,
        Request $request,
        ManagerRegistry $managerRegistry,
        WordGenerator $wordGenerator,
        LetterRepository $letterRepository
    ): Response {
        if ($word->getStudyLetter()) {
            $position = $word->getStudyLetter()->getPosition();
        }
        $letter = $word->getSerie()->getLetter()->getContent();
        $endPoints = [];
        foreach ($word->getEndpoints() as $endpoint) {
            $endPoints[] = $endpoint->getPosition() + 1;
        }
        $muteLetters = [];
        foreach ($word->getMuteLetters() as $muteLetter) {
            $muteLetters[] = $muteLetter->getPosition() + 1;
        }
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $managerRegistry->getManager();
            $word = $form->getData();
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
            $endpointLetters = $wordGenerator->generateEndpoint(
                $word->getContent(),
                $request->request->get('clickedLetters')
            );
            foreach ($endpointLetters as $position) {
                $endpoint = new Endpoint();
                $endpoint->setPosition($position);
                $entityManager->persist($endpoint);
                $word->addEndpoint($endpoint);

                $entityManager->flush();
            }
            return $this->redirectToRoute('admin_series_show', ['id' => $word->getSerie()->getId()]);
        }
        return $this->renderForm('admin/word/edit.html.twig', [
            'word' => $word,
            'form' => $form,
            'endpoints' => $endPoints,
            'muteLetters' => $muteLetters,
            'letter' => $letter,
            'position' => $position ?? null,
        ]);
    }
}
