<?php

namespace App\Form;

use App\Entity\Festival;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SearchBarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction('/festivals')
            ->add('city', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'input input__small search-bar__input'
                ]
            ])
            ->add('begin_at', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input input__small search-bar__input',
                    'placeholder' => 'Date de début'
                ]
            ])
            ->add('end_at', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input input__small search-bar__input',
                    'placeholder' => 'Date de fin'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Festival::class,
        ]);
    }
}
