<?php
/**
 * Created by PhpStorm.
 * User: Radzio
 * Date: 13.08.2018
 * Time: 15:43
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
    /**
     * @author Jadawiga Kalinowska <7jadzia7@gmail.com> // add label
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class ,[
                'label' => 'user.email',
            ])
            ->add('username', TextType::class ,[
                'label' => 'user.username',
            ])
            ->add('brochure', FileType::class,
                array('label' => 'user.photo',
                    'required' => false))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'user.password'),
                'second_options' => array('label' => 'user.password2'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}