<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Tournament;
use App\Entity\ExpectedResults;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ExpectedResults10Type
 * @package App\Form
 * @author Mateusz Poniatowski <mateusz@live.hk>
 */

class ExpectedResults10Type extends AbstractType
{


    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('FirstTeamScoreExpected', NumberType::class, array(
                'attr' => array('min' => 0, 'max' => 50),
                'label' => 'expected_results.FirstTeamScoreExpected',
            ))
            ->add('SecondTeamScoreExpected', NumberType::class, array(
                'attr' => array('min' => 0, 'max' => 50),
                'label' => 'expected_results.SecondTeamScoreExpected',
            ))

            ->add('NameOfMeeting', null,[
                'label' => 'expected_results.name_of_meeting',
            ]);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpectedResults::class,
        ]);
    }
}
