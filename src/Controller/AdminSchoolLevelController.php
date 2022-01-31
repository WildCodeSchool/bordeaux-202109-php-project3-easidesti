<?php

namespace App\Controller;

use App\Entity\SchoolLevel;
use App\Form\SchoolLevelType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion_des_classes", name="admin_school_level_")
 */
class AdminSchoolLevelController extends AbstractController
{
    /**
     * @Route("/creation", name="new")
     */
    public function newSchoolLevel(Request $request): Response
    {
        $schoolLevel = new SchoolLevel();
        $form = $this->createForm(SchoolLevelType::class, $schoolLevel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $schoolLevel = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($schoolLevel);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'La classe a bien été créé!'
            );
            return $this->redirectToRoute('admin_series');
        }
        return $this->renderForm('admin/registration/schoolLevel/newSchoolLevel.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("/selection_classe", name="select_school_level")
     */
    public function selectSchoolLevelForEdit(ManagerRegistry $managerRegistry): Response
    {
        $schoolLevels = $managerRegistry->getRepository(SchoolLevel::class)->findAll();

        return $this->render('admin/registration/schoolLevel/selectSchoolLevel.html.twig', [
            'schoolLevels' => $schoolLevels,
        ]);
    }
    /**
     * @Route("/modification_classe/{id}", name="edit")
     */
    public function editSchoolLevel(
        Request $request,
        SchoolLevel $schoolLevel,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(SchoolLevelType::class, $schoolLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'success',
                'L\'établissement a bien été modifié!'
            );
            return $this->redirectToRoute('admin_series', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/registration/schoolLevel/editSchoolLevel.html.twig', [
            'schoolLevel' => $schoolLevel,
            'form' => $form,
        ]);
    }
}
