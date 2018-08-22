<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    /**
     * @author Jadawiga Kalinowska <7jadzia7@gmail.com> // add label
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('first_team_score')
            ->add('second_team_score')

            ->add('TypeofWeight', null,[
                'label' => 'game_table.weigh',
                ])
            ->add('game_date', DateTimeType::class, [
                'date_widget' => 'single_text',
                'label' => 'game_table.game_date',
            ])
            ->add('tournament', null,[
                'label' => 'game_table.weigh',
            ])
            ->add('first_team', null,[
                'label' => 'tournament_table.tournament',
            ])
            ->add('second_team', null,[
                'label' => 'game_table.second_team',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);


    }
}
