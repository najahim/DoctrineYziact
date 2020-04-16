<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Emplacement;
use App\Entity\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmplacementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_etablissement')
            ->add('latitude')
            ->add('longitude')
            ->add('description')
            ->add('adresse', EntityType::class,[
                'class'=>Adresse::class,
                'choice_label' => function(Adresse $adresse) {
                    return sprintf('(%d) %s %d %s, %s %s', $adresse->getId(), $adresse->getRue(),$adresse->getNumeroRue(),$adresse->getVille(),
                        $adresse->getCodePostal(),$adresse->getPays());
                },
                'placeholder' => 'Choisir adresse'
            ])
            ->add('envoyer', SubmitType::class)
            //->add('adresse-rue')
            //->add('envoyer', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Emplacement::class,
        ]);
    }
}
