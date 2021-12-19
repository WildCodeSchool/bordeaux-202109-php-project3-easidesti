<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom :',
                'attr' => [
                    'class' => 'text-center border rounded-3 shadow-lg',
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'class' => 'text-center border rounded-3 shadow-lg',
                ]
            ])
            ->add('schoolLevel', ChoiceType::class, [
                'label' => 'Classe :',
                'choices' => [
                    'CM1' => 'CM1',
                    'CM2' => 'CM2',
                    '6E' => '6E',
                ],
                'attr' => [
                    'class' => 'text-center border rounded-3 shadow-lg',
                ]
            ])
            ->add('school', TextType::class, [
                'label' => 'Etablissement :',
                'attr' => [
                    'class' => 'text-center border rounded-3 shadow-lg',
                ]
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Pseudo :',
                'attr' => [
                    'class' => 'text-center border rounded-3 shadow-lg',
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe :',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'text-center border rounded-3 shadow-lg',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'merci de rentrer votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
