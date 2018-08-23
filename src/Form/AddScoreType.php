<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddScoreType extends AbstractType
{
    /**
     * @author Jadawiga Kalinowska <7jadzia7@gmail.com>
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, array(
                'choices' => array(
                    'game_status.executed'  => 'executed' ,
                    'game_status.annulled' =>  'annulled' ,
                    'game_status.not_executed' =>  'not executed' ,
                ),
                'label' => 'game.status',
            ))
             ->add('first_team_score', NumberType::class, array(
                 'attr' => array('min' => 0, 'max' => 50),
                 'label' => 'game_table.first_team_score',
             ))
            ->add('second_team_score', NumberType::class, array(
                'attr' => array('min' => 0, 'max' => 50),
                'label' => 'game_table.second_team_score',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);


    }
}
