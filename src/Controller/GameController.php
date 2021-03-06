<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Serie;
use App\Entity\Training;
use App\Entity\User;
use App\Entity\Word;
use App\Service\WorkLetter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eleve")
 */
class GameController extends AbstractController
{

    public const MAX_ERROR_ALLOWED = 3;

    public const TRAINING_START = 1;

    private SessionInterface $session;

    private ManagerRegistry $managerRegistry;

    public function __construct(RequestStack $requestStack, ManagerRegistry $doctrine)
    {
        $this->session = $requestStack->getCurrentRequest()->getSession();
        $this->managerRegistry = $doctrine;
    }

    /**
     * @Route("/game", name="game_init")
     */
    public function initEasiGame(WorkLetter $workLetter): Response
    {
        $this->session->remove('helps');
        $entityManager = $this->managerRegistry->getManager();
        if ($this->getUser()->getHasTest() === false) {
            return $this->redirectToRoute('training_training', [
                'trainingNumber' => self::TRAINING_START,
            ]);
        }
        if (!$this->getUser()->hasNeedTest()) {
            return $this->redirectToRoute('congralate');
        }
        $lastTraining = $this->getUser()->getLastTraining();
        $lastGame = $this->managerRegistry->getRepository(Game::class)
            ->findOneBy(['player' => $this->getUser()], ['id' => 'DESC']);
        $workSerie = $workLetter->getSerieForResultTraining($lastTraining, $lastGame);
        $game = new Game();
        $game->setIsEasi(true);
        $game->setPlayer($this->getUser());
        $game->setstep(0);
        $game->setErrorCount(0);
        $game->setErrorStep(0);
        $game->setScore(0);
        $game->setSerie($workSerie);
        $entityManager->persist($game);
        $entityManager->flush();
        return $this->redirectToRoute('phoneme', [
            'id' => $game->getId(),
            'serie' => $workSerie,
        ]);
    }
    /**
     * @Route("/easi/game/{id}", name="game_play")
     */
    public function play(Game $game): Response
    {
        $words = $game->getSerie()->getWords();
        $step = $game->getStep();
        if (!isset($words[$step])) {
            return $this->redirectToRoute('recap_game', [
                'game' => $game->getId(),
            ]);
        }
        $word = $words[$step];
        $letters = mb_str_split($word->getContent());
        if ($word->getStudyLetter()) {
            $position = $word->knowLetterPosition();
        }
        if ($word->getMuteLetters()) {
            $muteLettersPositions = [];
            foreach ($word->getMuteLetters() as $muteLetter) {
                $muteLettersPositions[$muteLetter->getPosition() + 1] = $muteLetter->getPosition() + 1;
            }
        }
        return $this->render('easi/index.html.twig', [
            'game'                  => $game,
            'word'                  => $word,
            'istraining'            => false,
            'position'              => $position ?? null,
            'letters'               => $letters,
            'muteLettersPositions'  => $muteLettersPositions ?? null,
        ]);
    }

    /**
     * @Route("/easi/game/{id}/mot/{word}/prononciation/{picture}", name="check_response")
     */
    public function checkResponse(Game $game, Word $word, string $picture): Response
    {
        $correctPicture = $word->getPronunciation()->getPicture();
        if ($game->getErrorStep() === (self::MAX_ERROR_ALLOWED - 1) && $correctPicture !== $picture) {
            $game->setStep($game->getStep() + 1);
            $game->setErrorStep(0);
            $successType = 'fail';
        } elseif ($correctPicture === $picture) {
            $game->setStep($game->getStep() + 1);
            $game->setScore($game->getScore() + (3 - $game->getErrorStep()));
            $game->setErrorStep(0);
            $successType = true;
        } else {
            $game->setErrorStep($game->getErrorStep() + 1);
            $game->setErrorCount($game->getErrorCount() + 1);
            $successType = false;
        }
        $this->managerRegistry->getManager()->flush();
        return $this->redirectToRoute('easiresult_step', [
            'word'    => $word->getId(),
            'id'      => $game->getId(),
            'success' => $successType,
        ]);
    }
}
