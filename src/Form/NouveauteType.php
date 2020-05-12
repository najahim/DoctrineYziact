<?php

namespace App\Form;

use App\Entity\Borne;
use App\Entity\Langue;
use App\Entity\Manager;
use App\Entity\Nouveaute;
use App\Entity\TypeNouveaute;
use App\Repository\BorneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NouveauteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $idU=$options['idU'];

        $builder
            ->add('titre')
            ->add('contenu', TextareaType::class)
            ->add('lien_image', FileType::class, [
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1500k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => "Merci d'utiliser un JPEG ou un PNG",
                    ])
                ],
            ])
            ->add('date_nouveaute', DateType::class, [
                'data' => new \DateTime(),
                'widget' => 'single_text'
            ])
            // ->add('auteur_nom')
            // ->add('auteur_prenom')
            //->add('langue')
            // ->add('langue', EntityType::class,[
            //     'class'=>Langue::class,
            //     'choice_label' => function(Langue $langue) {
            //         return sprintf('(%d) %s', $langue->getId(), $langue->getDescription());
            //     },
            //     'placeholder' => 'Choisir une langue'
            // ])
            //->add('typenouveaute')
            // ->add('typenouveaute', EntityType::class,[
            //     'class'=>TypeNouveaute::class,
            //     'choice_label' => function(TypeNouveaute $type) {
            //         return sprintf('(%d) %s', $type->getId(), $type->getTypeNouveaute());
            //     },
            //     'placeholder' => 'Choisir un type'
            // ])
            //->add('bornes')
            ->add('bornes', EntityType::class,[
                'required' => false,
                'class'=>Borne::class,

                'query_builder' => function (BorneRepository $er) use ($idU){


                    return $er->createQueryBuilder('b')
                        ->innerJoin('b.flottes', 'f')
                        ->innerJoin('f.manager', 'm')
                        ->andWhere('f.manager = :val')
                        ->setParameter('val', $idU);

                        //->getResult();

                },
                 'choice_label' => 'nom',

                'placeholder' => 'Choisir bornes',
                'multiple' => true,
                'disabled' => true,
                'attr' => ['style' => 'display:none;']
            ])
            // ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nouveaute::class,
        ]);
        $resolver->setRequired(
          'idU'
        );
    }
}
