<?php

namespace App\Form;

use App\Entity\Tournament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Tournament1Type extends AbstractType
{
    /**
     * @author Jadawiga Kalinowska <7jadzia7@gmail.com> // add label
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,[
                'label' => 'tournament_table.name',
            ])
            ->add('TypeOfEvent', null,[
                'label' => 'tournament_table.type',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tournament::class,
        ]);
    }
}
