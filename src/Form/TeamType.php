<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
/*
 * @author Jadwiga Kalinowska <7jadzia7@gmail.com>
 * add label
 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,[
                'label' => 'team_table.name',
            ])
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'team_table.representation'  => 'representation' ,
                    'team_table.club' =>  'club' ,
                ),
                'label' => 'team_table.type',
                ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
