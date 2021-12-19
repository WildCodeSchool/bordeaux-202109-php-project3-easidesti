<?php

namespace App\Form;

use App\Entity\Letter;
use App\Entity\Word;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class, [
                'label' => 'Entrez le mot',
            ])
            ->add('definition', TextareaType::class, [
                'label' => 'Définition',
                'required' => false,
            ])
            ->add('audio', FileType::class, [
                'required' => false,
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image',
                'required' => false,
            ])
            ->add('letters', EntityType::class, [
                'label' => 'Lettres',
                'class' => Letter::class,
                'choice_label' => 'content',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'd-flex justify-content-around',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Word::class,
        ]);
    }
}
