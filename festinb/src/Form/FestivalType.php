<?php

namespace App\Form;

use App\Entity\Festival;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FestivalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du festival',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'attr' => [
                    'class' => 'form-control form__label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom de festival',
                    ])
                ],
            ])
            ->add('begin_at', DateType::class, [
                'label' => 'Date de début',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ajouter une date de début',
                    ])
                ],
            ])
            ->add('end_at', DateType::class, [
                'label' => 'Date de fin',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ajouter une date de début',
                    ])
                ],
            ])

            ->add('city', TextType::class, [
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'attr' => [
                    'class' => 'form-control form__label'
                ]
            ])

            ->add('country', TextType::class, [
                'label' => 'Pays',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'attr' => [
                    'class' => 'form-control form__label'
                ]
            ])

            ->add('short_description', TextareaType::class, [
                'label' => 'Description courte',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ajouter une description',
                    ])
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Longue description',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Festival::class,
        ]);
    }
}
