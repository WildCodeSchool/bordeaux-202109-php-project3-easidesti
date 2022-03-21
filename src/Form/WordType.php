<?php

namespace App\Form;

use App\Entity\Letter;
use App\Entity\Pronunciation;
use App\Entity\Serie;
use App\Entity\StudyLetter;
use App\Entity\Word;
use App\Repository\PronunciationRepository;
use App\Repository\SerieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

use function PHPUnit\Framework\isNull;

class WordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class, [
                'label' => 'Entrez le mot',
            ])
            ->add('pronunciation', EntityType::class, [
                'label'        => 'Prononciation',
                'class'        => Pronunciation::class,
                'choice_label' => 'letterGrapheme',
                'expanded'     => false,
                'multiple'     => false,
                'attr'         => [
                    'class'    => 'd-flex col-4',
                ],
                'query_builder' => function (PronunciationRepository $pr) {
                    return $pr->createQueryBuilder('p')
                        ->orderBy('p.picture', 'ASC');
                }
            ])
            ->add('definition', TextareaType::class, [
                'label'    => 'Définition',
                'required' => false,
                'attr'     => [
                    'rows' => '6',
                ],
            ])
            ->add('imageFile', VichFileType::class, [
                'label'        => 'image du mot',
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
            ])
        ;
        if ($options['edit'] === true) {
            $builder
                ->add('serie', EntityType::class, [
                    'label' => 'Série',
                    'class'        => Serie::class,
                    'choice_label' => 'fullName',
                    'expanded'     => false,
                    'multiple'     => false,
                    'attr'         => [
                        'class'    => 'd-flex col-4',
                    ]
                ]);
        } else {
            $builder
                ->add('serie', EntityType::class, [
                    'label' => 'Série',
                    'class'        => Serie::class,
                    'choice_label' => 'fullName',
                    'query_builder' => function (SerieRepository $sr) {
                        return $sr->createQueryBuilder('s')
                            ->orderBy('s.letter', 'ASC')
                            ->addOrderBy('s.level', 'ASC')
                            ->addOrderBy('s.number', 'ASC');
                    },
                    'expanded'     => false,
                    'multiple'     => false,
                    'attr'         => [
                        'class'    => 'd-flex col-4',
                    ]
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Word::class,
            'edit' => false,
        ]);
    }
}
