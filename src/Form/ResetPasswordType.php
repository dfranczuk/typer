<?php
/**
 * Created by PhpStorm.
 * User: Radzio
 * Date: 17.08.2018
 * Time: 08:53
 */

namespace App\Form;




use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field_email', EmailType::class,[
            'label' => 'user.username',
            ])
            ->add('field_username', TextType::class ,[
                'label' => 'user.password',
            ])
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}