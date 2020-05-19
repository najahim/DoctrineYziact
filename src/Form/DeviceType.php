<?php

namespace App\Form;

use App\Entity\Peripherique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('adresse_mac')
            ->add('nom',TextType::class,[
                'required'=> false,
            ])
            ->add('p_type',TextType::class,[
                'required'=> false,
            ])
            ->add('p_os',TextType::class,[
                'required'=> false,
            ])
            ->add('p_brand',TextType::class,[
                'required'=> false,
            ])
            ->add('p_useragent',TextType::class,[
                'required'=> false,
            ])
            ->add('p_lang',TextType::class,[
                'required'=> false,
            ])
            ->add('p_browser',TextType::class,[
                'required'=> false,
            ])
            //->add('utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Peripherique::class,
        ]);
    }
}
