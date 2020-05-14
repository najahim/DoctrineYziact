<?php

namespace App\Form;

use App\Entity\Borne;
use App\Entity\Serveur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeployerServeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bornes',EntityType::class,[
                'class'=>Borne::class,
                'choice_label' => 'nom',
                'multiple' => true,

            ])
            ->add('serveur',EntityType::class,[
                'class'=>Serveur::class,
                'choice_label' => 'reseaux',
                'mapped'=>false
            ])
            //->add('envoyer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
