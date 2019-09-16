<?php

namespace App\Form;

use App\Entity\Energy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnergyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('month')
            ->add('electricityDay')
            ->add('electricityNight')
            ->add('gaz')
            ->add('water')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Energy::class,
        ]);
    }
}
