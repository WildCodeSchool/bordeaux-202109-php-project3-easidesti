<?php

namespace App\Form;

use App\Entity\Letter;
use App\Entity\Pronunciation;
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
                'label'    => 'Définition',
                'required' => false,
                'attr'     => ['rows' => '6'],
            ])
            ->add('pronunciation', EntityType::class, [
                'label'        => 'Prononciation',
                'class'        => Pronunciation::class,
                'choice_label' => 'grapheme',
                'expanded'     => true,
                'multiple'     => false,
                'attr'         => [
                    'class'    => 'd-flex col-4',
                ]
            ])
            ->add('picture', FileType::class, [
                'label'    => 'Image',
                'required' => false,
            ])
            ->add('letter', EntityType::class, [
                'class'        => Letter::class,
                'choice_label' => 'content',
                'expanded'     => true,
                'multiple'     => false,
                'attr'         => [
                    'class'    => 'd-flex col-4',
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
