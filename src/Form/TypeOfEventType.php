<?php

namespace App\Form;

use App\Entity\TypeOfEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeOfEventType extends AbstractType
{
/*
 * @author Jadwiga Kalinowska <7jadzia7@gmail.com>
 * add label
 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,[
                'label' => 'TypeOfEvent_table.name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeOfEvent::class,
        ]);
    }
}
