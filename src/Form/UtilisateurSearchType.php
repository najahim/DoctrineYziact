<?php

namespace App\Form;
use App\Entity\UtilisateurSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        /*->add('date', DateType::class,[
        'required'=> false,
        'label' => false,
        'attr' => [
            'placeholder' => 'date'
        ]
    ])*/
        ->add('email', TextType::class, [
            'required'=> false,
            'label' => false,
            'attr' => [
                'placeholder' => 'email'
            ]
        ])


    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UtilisateurSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
    public function getBlockPrefix()
    {
        return "";
    }
}
