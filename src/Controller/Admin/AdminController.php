<?php

namespace App\Controller\Admin;

use App\Entity\School;
use App\Entity\SchoolLevel;
use App\Entity\Serie;
use App\Entity\User;
use App\Form\SearchWordType;
use App\Form\SerieType;
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

    private ManagerRegistry $managerRegistry;

    public function __construct(
        SerieRepository $serieRepository,
        WordRepository $wordRepository,
        ManagerRegistry $managerRegistry
    )
    {
        $this->serieRepository = $serieRepository;
        $this->wordRepository  = $wordRepository;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route("/", name="home")
     */
    public function homePage(): Response
    {
        return $this->render('admin/home.html.twig');
    }

    /**
     * @Route("/reset_test", name="reset_test")
     */
    public function resetTest(): Response
    {
        $students = $this->getDoctrine()->getRepository(User::class)->findAll();
        foreach ($students as $student) {
            $student->setHasTest(0);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('admin_home');
    }

    /**
     * @Route("/affichage/series/easi", name="series")
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
     * @Route("/affichage/series/easi/{id}", name="series_show", methods={"GET", "POST"})
     */
    public function show(Serie $serie, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('admin_series_show', [
                'id' => $serie->getId(),
            ]);
        }
        return $this->renderForm('admin/series/show.html.twig', [
            'serie' => $serie,
            'form'  => $form,
        ]);
    }

    /**
     * @Route("/affichage/statistique/easi/ecoles", name="schools")
     */
    public function showAllSchools(ManagerRegistry $managerRegistry): Response
    {
        $schoolRepository = $managerRegistry->getRepository(School::class);
        $schools = $schoolRepository->findAll();
        return $this->render('admin/school/index.html.twig', [
            'schools'   => $schools,
        ]);
    }

    /**
    * @Route("/affichage/statistique/easi/ecole/{name}", name="school_show")
    */
    public function classroomSchool(School $school): Response
    {
        return $this->render('admin/school/show.html.twig', [
            'school_levels' => $school->getSchoolLevels(),
            'school' => $school,
        ]);
    }

    /**
     * @Route("/affichage/statistique/easi/classe/{name}", name="students")
     */
    public function allStudent(SchoolLevel $schoolLevel): Response
    {
        return $this->render('admin/student/index.html.twig', [
            'school_level' => $schoolLevel,
            'students' => $schoolLevel->getStudents(),
        ]);
    }

    /**
     * @Route("/affichage/statistique/easi/eleve/{nickname}", name="student_result_show")
     */
    public function showResultStudent(User $user): Response
    {
        return $this->render('admin/student/show.html.twig', [
            'student' => $user,
        ]);
    }
}
