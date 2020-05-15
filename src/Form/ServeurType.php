<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Serveur;
use App\Entity\TypeNouveaute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reseaux')
            //->add('derniere_MAJ')
            ->add('page_de_blocage')
            ->add('nb_max_borne')
            //->add('etat')
            ->add('etat', EntityType::class,[
                'class'=>Etat::class,
                'choice_label' => function(Etat $etat) {
                    return sprintf('%s', $etat->getEtat());
                },
            ])
            ->add('filtrage', CheckboxType::class, [
                'required' => false
            ])
            //->add('bornes')
            //->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serveur::class,
        ]);
    }
}
