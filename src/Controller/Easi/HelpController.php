<?php

namespace App\Controller\Easi;

use App\Entity\Game;
use App\Entity\Word;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("eleve/easi/help", name="easi_")
 */
class HelpController extends AbstractController
{
    private SessionInterface $session;

    private ManagerRegistry $managerRegistry;

    public function __construct(RequestStack $requestStack, ManagerRegistry $managerRegistry)
    {
        $this->session = $requestStack->getSession();
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route("/{game}/aide-1", name="helpOne")
     */
    public function showHelpOne(Game $game): Response
    {
        $word = $game->getSerie()->getWords()[$game->getStep()];
        if (!$this->hasEverRead($word, 1)) {
            $this->handleSession($word, 1);
            $game->setHelpCount($game->getHelpCount() + 1);
        }
        $colors = [
            'success',
            'info',
            'warning',
            'danger',
        ];
        $letter = $word->getLetter();
        $allEndpoints = [];
        foreach ($word->getEndpoints() as $endpoint) {
            $allEndpoints[] = $endpoint->getPosition();
        }
        $endpoints = array_unique($allEndpoints);
        $syllabes = [];
        for ($i = 0; $i < count($endpoints); $i++) {
            $position = 0;
            $lenght = $endpoints[$i] + 1;
            if (isset($endpoints[$i - 1])) {
                $position = $endpoints[$i - 1] + 1;
                $lenght = $endpoints[$i] - $endpoints[$i - 1];
            }
            $syllabes[] = mb_substr($word->getContent(), $position, $lenght);
        }
        $this->managerRegistry->getManager()->flush();
        return $this->render('easi/helpOne.html.twig', [
            'word' => $word,
            'letter' => $letter,
            'syllabes' => $syllabes,
            'colors' => $colors,
            'game' => $game,
        ]);
    }

    /**
     * @Route("/{game}/aide-2", name="helpTwo")
     *
     */
    public function showHelpTwo(Game $game): Response
    {
        $word = $game->getSerie()->getWords()[$game->getStep()];

        if (!$this->hasEverRead($word, 2)) {
            $this->handleSession($word, 2);
            $game->setHelpCount($game->getHelpCount() + 1);
        }
        $this->managerRegistry->getManager()->flush();
        return $this->render('easi/helpTwo.html.twig', [
            'word' => $word,
            'game' => $game,
        ]);
    }

    /**
    * @Route("/{game}/aide-3", name="helpThree")
    */
    public function showHelpThree(Game $game): Response
    {
        $word = $game->getSerie()->getWords()[$game->getStep()];
        if (!$this->hasEverRead($word, 3)) {
            $this->handleSession($word, 3);
            $game->setHelpCount($game->getHelpCount() + 1);
        }
        $this->managerRegistry->getManager()->flush();
        return $this->render('easi/helpThree.html.twig', [
            'word'  => $word,
            'game'  => $game,
            ]);
    }

    private function handleSession(Word $word, int $help): void
    {
        $sessionHelps = $this->session->get('helps') ?? [];
        if (!in_array($word->getContent() . '-' . $help, $sessionHelps)) {
            $sessionHelps[] = $word->getContent() . '-' . $help;
            $this->session->set('helps', $sessionHelps);
        }
    }

    private function hasEverRead(Word $word, int $help): bool
    {
        $sessionHelps = $this->session->get('helps') ?? [];
        $result = false;
        if (in_array($word->getContent() . '-' . $help, $sessionHelps)) {
            $result = true;
        }
        return $result;
    }
}
