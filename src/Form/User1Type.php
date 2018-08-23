<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class User1Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @author Radoslaw Albiniak <radoslaw.albiniak@gmail.com>
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if (in_array('ROLE_ADMIN', $options['role'])) {
            $builder
                ->add('email', EmailType::class)
                ->add('username', TextType::class)
                ->add('brochure', FileType::class,
                    array('label' => 'Zdjecie(jpg,jpeg,png)', 'data_class' => null,
                        'required' => false))
                ->add('role', ChoiceType::class, array(
                    'choices' => array(
                        'Admin' => '["ROLE_ADMIN"]',
                        'User' => '["ROLE_USER"]',
                    )));
        } else {
            $builder
                ->add('email', EmailType::class)
                ->add('username', TextType::class)
                ->add('brochure', FileType::class,
                    array('label' => 'Zdjecie(jpg,jpeg,png)', 'data_class' => null,
                        'required' => false))
                /*->add('role', ChoiceType::class, array(
                    'choices' => array(
                        'Admin' => '["ROLE_ADMIN"]',
                        'User' => '["ROLE_USER"]',
                    )))*/;
        }
        /*$builder
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('brochure', FileType::class,
                array('label' => 'Zdjecie(jpg,jpeg,png)', 'data_class' => null,
                    'required' => false))
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'Admin' => '["ROLE_ADMIN"]',
                    'User' => '["ROLE_USER"]',
                )));*/

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'role' => ['ROLE_USER']
        ]);
    }
}
