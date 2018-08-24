<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class GameType extends AbstractType
{

    /**
     * @author Jadawiga Kalinowska <7jadzia7@gmail.com> // add label
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            // ->add('first_team_score')
// ->add('second_team_score')

            ->add('TypeofWeight', null,[
                'label' => 'game_table.weigh',
            ])
            ->add('game_date', DateTimeType::class, [
                'date_widget' => 'single_text',
                'label' => 'game_table.game_date',
            ])
            ->add('tournament', null,[
                'label' => 'tournament_table.tournament',
            ])
            ->add('first_team', null,[
                'label' => 'game_table.first_team',
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
