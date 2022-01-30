<?php

namespace App\Controller;

use App\Entity\School;
use App\Form\SchoolType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/etablissement", name="admin_school_")
 */
class AdminSchoolController extends AbstractController
{
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
     * @Route("/liste_des_etablissement", name="show_school")
     */
    public function showSchoolForEdit(ManagerRegistry $managerRegistry): Response
    {
        $schools = $managerRegistry->getRepository(School::class)->findAll();

        return $this->render('admin/registration/school/showSchool.html.twig', [
            'schools' => $schools,
        ]);
    }

    /**
     * @Route("/modification/{id}", name="edit")
     */
    public function editSchool(Request $request, School $school, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
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
}
