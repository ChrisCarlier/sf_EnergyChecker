<?php

namespace App\Form;

use App\Entity\Energy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnergyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('month', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('electricityDay',NumberType::class)
            ->add('electricityNight',NumberType::class)
            ->add('gaz',NumberType::class)
            ->add('water',NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Energy::class,
        ]);
    }

    private function getChoices(){
        $choices = Energy::MONTH;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
