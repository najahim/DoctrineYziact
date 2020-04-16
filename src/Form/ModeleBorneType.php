<?php

namespace App\Form;

use App\Entity\ModeleBorne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleBorneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('lan_interface')
            ->add('wan_interface')
            ->add('chemin_led_status')
            ->add('chemin_led_ok')
            ->add('chemin_led_erreur')
            ->add('gain_antenne')
            ->add('radio_dev')
            ->add('ht_capab')
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModeleBorne::class,
        ]);
    }
}
