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
 * @Route("/admin/gestion_des_etablissements", name="admin_school_")
 */
class AdminSchoolController extends AbstractController
{
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
     * @Route("/liste_des_etablissements", name="show_school")
     */
    public function showSchoolForEdit(ManagerRegistry $managerRegistry): Response
    {
        $schools = $managerRegistry->getRepository(School::class)->findAll();

        return $this->render('admin/registration/school/showSchool.html.twig', [
            'schools' => $schools,
        ]);
    }

    /**
     * @Route("/modification_etablissement/{id}", name="edit")
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

    /**
     * @Route("/suppression_etablissement/{id}", name="delete")
     */
    public function deleteSchool(School $school, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($school);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'L\'établissement a bien été supprimé!'
        );
        return $this->redirectToRoute('admin_school_show_school');
    }
}
