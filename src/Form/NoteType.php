<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note',
                NumberType::class,
                [
                    'label' => 'Note',
                    'attr' => [
                        'placeholder' => 'Note',
                        'class' => 'form-control',
                    ],
                ])
            ->add('description',
                TextType::class,
                [
                    'label' => 'Description',
                    'attr' => [
                        'placeholder' => 'Description',
                        'class' => 'form-control',
                    ],
                ])
            ->add('coeff',
                NumberType::class,
                [
                    'label' => 'Coefficient',
                    'attr' => [
                        'placeholder' => 'Coefficient',
                        'class' => 'form-control',
                    ],
                ])
            ->add('point',
                NumberType::class,
                [
                    'label' => 'Point',
                    'attr' => [
                        'placeholder' => 'Point',
                        'class' => 'form-control',
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
