<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\User;
use App\Form\SearchWordType;
use App\Repository\SerieRepository;
use App\Repository\WordRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    private SerieRepository $serieRepository;

    private WordRepository $wordRepository;

    public function __construct(SerieRepository $serieRepository, WordRepository $wordRepository)
    {
        $this->serieRepository = $serieRepository;
        $this->wordRepository  = $wordRepository;
    }

    /**
     * @Route("/series", name="series")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchWordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $keyword = $form->getData()['search'];
            $words = $this->wordRepository->searchByKeyword($keyword);
            return $this->forward('App\Controller\AdminController::searchWord', [
                'words' => $words,
            ]);
        }
        $series = $this->serieRepository->findBy([], ['letter' => 'asc', 'level' => 'asc', 'number' => 'asc']);
        $withStatsSeries = [];
        foreach ($series as $serie) {
            $serie->setNoDefinitionCount($this->wordRepository->countNoDefinition($serie));
            $serie->setNoEndPointCount($this->serieRepository->countNoEndpoint($serie));
            $withStatsSeries[] = $serie;
        }
        return $this->renderForm('admin/series/index.html.twig', [
            'series' => $withStatsSeries,
            'form'   => $form,
        ]);
    }

    public function searchWord($words)
    {
        return $this->renderForm('admin/series/search.html.twig', [
            'words' => $words,
        ]);
    }

    /**
     * @Route("/series/{id}", name="series_show", methods={"GET"})
     */
    public function show(Serie $serie): Response
    {
        return $this->renderForm('admin/series/show.html.twig', [
            'serie' => $serie,
        ]);
    }

    /**
     * @Route("/eleves", name="student_show")
     */
    public function showAllStudent(ManagerRegistry $managerRegistry): Response
    {
        $studentRepository = $managerRegistry->getRepository(User::class);
        $users = $studentRepository->findALL();
        $students = [];
        foreach ($users as $user) {
            if (in_array('STUDENT', $user->getRoles())) {
                $students[] = $user;
            }
        }
        return $this->render('admin/student/showStudent.html.twig', [
            'students' => $students,
        ]);
    }
}
