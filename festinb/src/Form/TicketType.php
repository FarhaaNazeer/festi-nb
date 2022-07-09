<?php

namespace App\Form;

use App\Entity\Festival;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Nom du billet',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('start_date', DateType::class, [
                'label' => 'Date de début',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
//            ->add('artists')
            ->add('festival', EntityType::class, [
                'class' => Festival::class,
                'choice_label' => 'name',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
