<?php

namespace App\Form;

use App\Entity\Manager;
use App\Entity\Organisation;
use App\Entity\TypeOrganisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_organisation')
            ->add('type')
            ->add('type', EntityType::class,[
                'class'=>TypeOrganisation::class,
                'choice_label' => function(TypeOrganisation $type) {
                    return sprintf('(%d) %s', $type->getId(), $type->getTypeOrganisation());
                },
                'placeholder' => 'Choisir un type'
            ])
            ->add('manager', EntityType::class,[
                'class'=>Manager::class,
                'choice_label' => function(Manager $user) {
                    return sprintf('(%d) %s', $user->getId(), $user->getEmail());
                },
                'placeholder' => 'Choisir un Manager'
            ])
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organisation::class,
        ]);
    }
}
