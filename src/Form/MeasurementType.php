<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperature', NumberType::class, [
                'scale' => 2,
                'invalid_message' => 'Temperature must be a valid number.',
                'attr' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ])
            ->add('pressure', NumberType::class, [
                'scale' => 0,
                'invalid_message' => 'Pressure must be a valid number.',
                'attr' => [
                    'min' => 800,
                    'max' => 1100,
                ],
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'invalid_message' => 'Please enter a valid date.',
            ])
            ->add('wind_speed', NumberType::class, [
                'scale' => 2,
                'invalid_message' => 'Wind speed must be a valid number.',
                'attr' => [
                    'min' => 0,
                    'max' => 500,
                ],
            ])
            ->add('wind_direction', NumberType::class, [
                'scale' => 1,
                'invalid_message' => 'Wind direction must be a valid number.',
                'attr' => [
                    'min' => 0,
                    'max' => 360,
                ],
            ])
            ->add('rain', NumberType::class, [
                'scale' => 1,
                'invalid_message' => 'Rain must be a valid number.',
                'attr' => [
                    'min' => 0,
                    'max' => 1000,
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
