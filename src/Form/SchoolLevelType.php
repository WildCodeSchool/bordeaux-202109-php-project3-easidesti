<?php

namespace App\Form;

use App\Entity\School;
use App\Entity\SchoolLevel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchoolLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('school', EntityType::class, [
                'class' => School::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label' => 'Nom de l\'établissement de la classe:',
                'attr' => [
                    'class' => 'text-center border rounded-3 shadow-lg',
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de la classe',
                'attr' => [
                    'class' => 'text-center border rounded-3 shadow-lg',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SchoolLevel::class,
        ]);
    }
}
