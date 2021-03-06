<?php

namespace App\Controller\Easi;

use App\Entity\Endpoint;
use App\Entity\Letter;
use App\Entity\MuteLetter;
use App\Entity\StudyLetter;
use App\Entity\Word;
use App\Form\WordType;
use App\Service\Definition;
use App\Service\WordGenerator;
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
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route("/ajout", name="new")
     */
    public function index(
        Request $request,
        WordGenerator $wordGenerator
    ): Response {
        $url = substr($this->generateUrl('word_definition', ['word' => 'u']), 0, -1);
        $letterRepository = $this->managerRegistry->getRepository(Letter::class);
        $studyLetterRepository = $this->managerRegistry->getRepository(StudyLetter::class);
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $letterData = $request->request->get('clickedLetterStudy')[0];
            if (count($request->request->get('clickedLetterStudy')) > 1) {
                $this->addFlash('danger', 'Vous devez rentrer qu\'une seule lettre');
                return $this->redirectToRoute('word_new');
            }
            $letter = $letterRepository->findOneBy(['content' => substr($letterData, -1)]);
            $positionLetter = (int)substr($letterData, 0, -2);
            $linkPosition = $wordGenerator->generateLetterPosition(
                mb_str_split($word->getContent()),
                $letter->getContent(),
                $positionLetter
            );
            $studyLetter = $studyLetterRepository->findOneBy(['audio' => $linkPosition]);
            $word->setLetter($letter);
            $word->setStudyLetter($studyLetter);
            $entityManager = $this->managerRegistry->getManager();
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
            $this->addFlash('success', 'Le mot a bien ??t?? ajout?? !');
            return $this->redirectToRoute('admin_series');
        }
        return $this->renderForm('admin/word/new.html.twig', [
            'form' => $form,
            'url' => $url,
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
        WordGenerator $wordGenerator
    ): Response {
        $url = $this->generateUrl('word_definition', ['word' => $word->getContent()]);
        $studyLetterRepository = $this->managerRegistry->getRepository(StudyLetter::class);
        $entityManager = $this->managerRegistry->getManager();
        if ($word->getStudyLetter()) {
            $position = $word->getStudyLetter()->getPosition();
        }
        if ($word->getSerie()) {
            $letter = $word->getSerie()->getLetter()->getContent();
        }
        $endPoints = [];
        foreach ($word->getEndpoints() as $endpoint) {
            $endPoints[] = $endpoint->getPosition();
        }
        $muteLetters = [];
        foreach ($word->getMuteLetters() as $muteLetter) {
            $muteLetters[] = $muteLetter->getPosition();
        }
        $form = $this->createForm(WordType::class, $word, ['edit' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $wordGenerator->cleanWordLetters($word, Endpoint::class);
            $wordGenerator->cleanWordLetters($word, MuteLetter::class);
            $letterData = $request->request->get('clickedLetterStudy')[0];
            if (count($request->request->get('clickedLetterStudy')) > 1) {
                $this->addFlash('danger', 'Vous devez rentrer qu\'une seule lettre');
                return $this->redirectToRoute('word_new');
            }
            $letter = $word->getSerie()->getLetter()->getContent();
            $positionLetter = (int)substr($letterData, 0, -2);
            $linkPosition = $wordGenerator->generateLetterPosition(
                mb_str_split($word->getContent()),
                $letter,
                $positionLetter
            );
            $studyLetter = $studyLetterRepository->findOneBy(['audio' => $linkPosition]);
            $word->setStudyLetter($studyLetter);
            $allEndpoints = $entityManager->getRepository(Endpoint::class)->findBy(['word' => $word]) ?? [];
            foreach ($allEndpoints as $endpoint) {
                $word->removeEndpoint($endpoint);
            }
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
            }
            $entityManager->flush();
            $this->addFlash('success', 'Le mot a bien ??t?? modifi??');
            return $this->redirectToRoute('admin_series_show', ['id' => $word->getSerie()->getId()]);
        }
        return $this->renderForm('admin/word/edit.html.twig', [
            'word' => $word,
            'form' => $form,
            'endpoints' => $endPoints,
            'muteLetters' => $muteLetters,
            'letter' => $letter ?? '',
            'position' => $position ?? null,
            'url' => $url,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Word $word, ManagerRegistry $managerRegistry): Response
    {
        $managerRegistry->getManager()->remove($word);
        $managerRegistry->getManager()->flush();
        $this->addFlash('success', 'Le mot ?? bien ??t?? supprimer');

        if ($word->getSerie()) {
            return $this->redirectToRoute('admin_series_show', ['id' => $word->getSerie()->getId()]);
        } else {
            return $this->redirectToRoute('admin_series');
        }
    }
}
