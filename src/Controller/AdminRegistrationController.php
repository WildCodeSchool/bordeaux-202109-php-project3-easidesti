<?php

namespace App\Controller;

use App\Entity\School;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion_des_utilisateurs", name="admin_registration_")
 */
class AdminRegistrationController extends AbstractController
{

    /**
     * @Route("/creation_eleve/selection_etablissement", name="select_school")
     */
    public function selectSchoolForCreateStudent(ManagerRegistry $managerRegistry): Response
    {
        $schools = $managerRegistry->getRepository(School::class)->findAll();

        return $this->render('admin/registration/user/selectSchoolForCreateStudent.html.twig', [
            'schools' => $schools,
        ]);
    }

    /**
     * @Route("/inscription_eleve/{name}", name="app_register")
     */
    public function register(
        School $school,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user, ['school' => $school]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $user->setRoles(['ROLE_STUDENT']);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash('success', 'L\'éléve a bien été inscrit');
            return $this->redirectToRoute('admin_series');
        }

        return $this->render('admin/registration/user/register.html.twig', [
            'registrationForm' => $form->createView(),
            'school' => $school,
        ]);
    }


    /**
     * @Route("/modifiaction_eleve/selection_eleve/", name="select_student_for_edit_student")
     */
    public function selectStudentForEditStudent(ManagerRegistry $managerRegistry): Response
    {
        $students = $managerRegistry->getRepository(User::class)->findAll();

        return $this->render('admin/registration/user/selectStudentForEditStudent.html.twig', [
            'students' => $students,
        ]);
    }

    /**
     * @Route("/modification_eleve/eleve/{id}", name="edit_student")
     */
    public function editStudent(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user, ['school' => $user->getSchoolLevel()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'success',
                'L\'élève a bien été modifié!'
            );
            return $this->redirectToRoute('admin_series', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/registration/user/editStudent.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/suppression_eleve/{id}", name="delete_student")
     */
    public function deleteStudent(User $user, ManagerRegistry $managerRegistry): Response
    {
        $managerRegistry->getManager()->remove($user);
        $managerRegistry->getManager()->flush();
        $this->addFlash(
            'success',
            'L\'élève a bien été supprimé!'
        );
        return $this->redirectToRoute('admin_registration_select_student_for_edit_student   ', [], Response::HTTP_SEE_OTHER);
    }

}
