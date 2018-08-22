<?php

namespace App\Form;

use App\Entity\TypeofWeight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeofWeightType extends AbstractType
{

    /**
     * @author Jadawiga Kalinowska <7jadzia7@gmail.com> // add label
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Weight', null,[
                'label' => 'type_weight_table.name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeofWeight::class,
        ]);
    }
}
