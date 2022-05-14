<?php

namespace App\Controller\Admin;

use App\Form\ChangePasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/changement_de_mot_de_passe", name="admin_change_password_")
 */
class AdminChangePasswordController extends AbstractController
{
    private ManagerRegistry $doctrine;
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher)
    {
        $this->doctrine = $doctrine;
        $this->passwordHasher = $passwordHasher;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ChangePasswordType::class, $this->getUser());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $this->getUser()->setPassword($this->passwordHasher->hashPassword($this->getUser(), $password));
            $this->doctrine->getManager()->flush();
            $this->addFlash('success', 'Votre mot de passe a bien été modifié');
            return $this->redirectToRoute('admin_series');
        }
        return $this->renderForm('admin/change_password/index.html.twig', [
            'form' => $form,
        ]);
    }
}
