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

$listener = function (FormEvent $event) {

};

class GameType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('first_team_score')
            ->add('second_team_score')
            ->add('TypeofWeight')
            ->add('game_date', DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('tournament')
            ->add('first_team')
            ->add('second_team');

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);


    }

}
