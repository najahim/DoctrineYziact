<?php

namespace App\Form;

use App\Entity\Peripherique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('adresse_mac')
            ->add('nom')
            ->add('p_type')
            ->add('p_os')
            ->add('p_brand')
            ->add('p_useragent')
            ->add('p_lang')
            ->add('p_browser')
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
