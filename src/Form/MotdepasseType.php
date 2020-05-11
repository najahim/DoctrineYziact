<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MotdepasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motdepasse', PasswordType::class, array(
                'mapped' => false
            ))

            ->add('newpassword', RepeatedType::class, array(

                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'options' => array(
                    'attr' => array(
                        'class' => 'password-field'
                    )
                ),
                'required' => true,
                'mapped'=> false
            ))

            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-primary btn-block'
                )

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
            ]);
    }
}
