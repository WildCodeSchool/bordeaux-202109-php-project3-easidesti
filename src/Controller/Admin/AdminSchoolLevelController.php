<?php

namespace App\Controller\Admin;

use App\Entity\SchoolLevel;
use App\Form\SchoolLevelType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion_des_classes", name="admin_school_level_")
 */
class AdminSchoolLevelController extends AbstractController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

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
            $this->managerRegistry->getManager()->persist($schoolLevel);
            $this->managerRegistry->getManager()->flush();
            $this->addFlash(
                'success',
                'La classe a bien été créé!'
            );
            return $this->redirectToRoute('admin_school_level_select_school_level');
        }
        return $this->renderForm('admin/registration/schoolLevel/newSchoolLevel.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("/selection_classe", name="select_school_level")
     */
    public function selectSchoolLevelForEdit(): Response
    {
        $schoolLevels = $this->managerRegistry->getRepository(SchoolLevel::class)->findAll();

        return $this->render('admin/registration/schoolLevel/selectSchoolLevel.html.twig', [
            'schoolLevels' => $schoolLevels,
        ]);
    }
    /**
     * @Route("/modification_classe/{id}", name="edit")
     */
    public function editSchoolLevel(
        Request $request,
        SchoolLevel $schoolLevel
    ): Response {
        $form = $this->createForm(SchoolLevelType::class, $schoolLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->managerRegistry->getManager()->flush();
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

    /**
     * @Route("/suppression_classe/{id}", name="delete")
     */
    public function deleteSchoolLevel(
        SchoolLevel $schoolLevel
    ): Response {
        $this->managerRegistry->getManager()->remove($schoolLevel);
        $this->managerRegistry->getManager()->flush();
        $this->addFlash(
            'success',
            'La classe a bien été supprimée!'
        );
        return $this->redirectToRoute('admin_school_level_select_school_level', [], Response::HTTP_SEE_OTHER);
    }
}
