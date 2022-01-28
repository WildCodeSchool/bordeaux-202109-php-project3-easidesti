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
 * @Route("/admin", name="admin_")
 */
class RegistrationController extends AbstractController
{

    /**
     * @Route("/selection_etablissement", name="select_school")
     */
    public function selectSchoolForLevelSchool(ManagerRegistry $managerRegistry): Response
    {
        $schools = $managerRegistry->getRepository(School::class)->findAll();

        return $this->render('admin/registration/selectSchool.html.twig', [
            'schools' => $schools,
        ]);
    }

    /**
     * @Route("/inscription/{role}", name="app_register")
     */
    public function register(
        string $role,
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
            $user->setRoles([$role]);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash('success', 'L\'éléve a bien été inscrit');
            return $this->redirectToRoute('admin_series');
        }

        return $this->render('admin/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
