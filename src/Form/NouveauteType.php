<?php

namespace App\Form;

use App\Entity\Langue;
use App\Entity\Manager;
use App\Entity\Nouveaute;
use App\Entity\TypeNouveaute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NouveauteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('contenu')
            ->add('lien_image')
            //->add('date_nouveaute')
            ->add('auteur_nom')
            ->add('auteur_prenom')
            //->add('langue')
            ->add('langue', EntityType::class,[
                'class'=>Langue::class,
                'choice_label' => function(Langue $langue) {
                    return sprintf('(%d) %s', $langue->getId(), $langue->getDescription());
                },
                'placeholder' => 'Choisir une langue'
            ])
            //->add('typenouveaute')
            ->add('typenouveaute', EntityType::class,[
                'class'=>TypeNouveaute::class,
                'choice_label' => function(TypeNouveaute $type) {
                    return sprintf('(%d) %s', $type->getId(), $type->getTypeNouveaute());
                },
                'placeholder' => 'Choisir un type'
            ])
            //->add('bornes')
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nouveaute::class,
        ]);
    }
}
