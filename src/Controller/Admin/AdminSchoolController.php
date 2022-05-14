<?php

namespace App\Controller\Admin;

use App\Entity\School;
use App\Form\SchoolType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion_des_etablissements", name="admin_school_")
 */
class AdminSchoolController extends AbstractController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route("/creation", name="new_school")
     */
    public function newSchool(Request $request): Response
    {
        $school = new School();
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $school = $form->getData();
            $this->managerRegistry->getManager()->persist($school);
            $this->managerRegistry->getManager()->flush();
            $this->addFlash(
                'success',
                'L\'établissement a bien été créé!'
            );
            return $this->redirectToRoute('admin_school_level_new');
        }
        return $this->renderForm('admin/registration/school/newSchool.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/liste_des_etablissements", name="show_school")
     */
    public function showSchoolForEdit(): Response
    {
        $schools = $this->managerRegistry->getRepository(School::class)->findAll();

        return $this->render('admin/registration/school/showSchool.html.twig', [
            'schools' => $schools,
        ]);
    }

    /**
     * @Route("/modification_etablissement/{id}", name="edit")
     */
    public function editSchool(Request $request, School $school): Response
    {
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->managerRegistry->getManager()->flush();
            $this->addFlash(
                'success',
                'L\'établissement a bien été modifié!'
            );

            return $this->redirectToRoute('admin_series', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/registration/school/editSchool.html.twig', [
            'school' => $school,
            'form'  => $form,
        ]);
    }

    /**
     * @Route("/suppression_etablissement/{id}", name="delete")
     */
    public function deleteSchool(School $school): Response
    {
        $this->managerRegistry->getManager()->remove($school);
        $this->managerRegistry->getManager()->flush();
        $this->addFlash(
            'success',
            'L\'établissement a bien été supprimé!'
        );
        return $this->redirectToRoute('admin_school_show_school');
    }
}
