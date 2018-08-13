<?php

namespace App\Form;

use App\Entity\ExpectedResults;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpectedResultsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('FirstTeamScore')
            ->add('SecondTeamScore')
            ->add('GameFirstTeam')
            ->add('GameSecondTeam')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpectedResults::class,
        ]);
    }
}
