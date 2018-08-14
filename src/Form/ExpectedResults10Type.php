<?php

namespace App\Form;

use App\Entity\ExpectedResults;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpectedResults10Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('FirstTeamScoreExpected', NumberType::class, array(
                'attr' => array('min' => 0, 'max' => 50)
            ))
            ->add('SecondTeamScoreExpected', NumberType::class, array(
                'attr' => array('min' => 0, 'max' => 50)
            ))
            ->add('NameOfMeeting')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpectedResults::class,
        ]);
    }
}
