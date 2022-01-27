<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\School;
use App\Entity\Serie;
use App\Entity\User;
use App\Form\SchoolType;
use App\Form\SearchWordType;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/series/{id}", name="series_show", methods={"GET", "POST"})
     */
    public function show(Serie $serie, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('admin_series_show',[
                'id' => $serie->getId(),
            ]);
        }
        return $this->renderForm('admin/series/show.html.twig', [
            'serie' => $serie,
            'form'  => $form,
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
        return $this->render('admin/student/index.html.twig', [
            'students' => $students,

        ]);
    }

    /**
     * @Route("/eleve/{nickname}", name="student_result_show")
     */
    public function showResultStudent(User $user): Response
    {
        $user -> getTrainings();

        return $this->render('admin/student/show.html.twig', [
            'student' => $user,
        ]);
    }

    /**
     * @Route("/nouvel_etablissement", name="new_school")
     */
    public function newSchool(Request $request): Response
    {
        $school = new School();
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $school = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($school);
            $entityManager->flush();
            return $this->redirectToRoute('admin_series');
        }
        return $this->renderForm('admin/registration/newSchool.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/modification/{name}", name="edit_school")
     */
    public function editSchool(Request $request, School $school, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_series', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/registration/editSchool.html.twig', [
            'school' => $school,
             'form'  => $form,
        ]);
    }

    /**
     * @Route("/liste_des_etablissement", name="show_school")
     */
    public function showSchool(ManagerRegistry $managerRegistry): Response
    {
        $schools = $managerRegistry->getRepository(School::class)->findAll();

        return $this->render('admin/registration/showSchool.html.twig', [
            'schools' => $schools,
        ]);
    }
}
