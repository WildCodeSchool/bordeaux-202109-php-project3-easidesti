<?php

namespace App\Controller;

use App\Entity\SchoolLevel;
use App\Form\SchoolLevelType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/class", name="admin_school_level_")
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


}
