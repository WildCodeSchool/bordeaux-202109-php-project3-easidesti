<?php

namespace App\Controller;

use App\Entity\Endpoint;
use App\Entity\MuteLetter;
use App\Entity\Word;
use App\Form\WordType;
use App\Repository\SerieRepository;
use App\Repository\WordRepository;
use App\Service\WordGenerator;
use App\Service\Definition;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/word", name="word_")
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
        SerieRepository $serieRepository
    ): Response {
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        WordGenerator $wordGenerator
    ): Response {
        $endPoints = [];
        foreach ($word->getEndpoints() as $endpoint) {
            $endPoints[] = $endpoint->getPosition();
        }
        $muteLetters = [];
        foreach ($word->getMuteLetters() as $muteLetter) {
            $muteLetters[] = $muteLetter->getPosition();
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
        ]);
    }
}
