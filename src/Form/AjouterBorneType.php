<?php

namespace App\Form;

use App\Entity\Borne;
use App\Entity\Contact;
use App\Entity\Emplacement;
use App\Entity\Etat;
use App\Entity\Flotte;
use App\Entity\ModeleBorne;
use App\Entity\Nouveaute;
use App\Entity\Serveur;
use App\Repository\EmplacementRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjouterBorneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse_mac')
            ->add('nom')
            // ->add('hostname')
            // ->add('derniere_emission',DateTimeType::class)
            ->add('ssid')
            ->add('Prog_wifi')
            ->add('channel', IntegerType::class)
            ->add('affichage_map', CheckboxType::class, [
                'required' => false
            ])
            // ->add('partage_stats', CheckboxType::class, [
            //     'required' => false
            // ])
            ->add('quota_user_duree',IntegerType::class)
            ->add('quota_user_max_bytes',IntegerType::class)
            ->add('filtrage',CheckboxType::class, [
                'required' => false
            ])
            ->add('portail_url')
            ->add('upload_rate')
            ->add('download_rate')
            ->add('txpower',IntegerType::class)
            // ->add('ip_adress_vpn_admin')
            ->add('date_mise_en_service',DateTimeType::class, [
                'data' => new \DateTime()
            ])
            ->add('date_expiration_test',DateTimeType::class, [
                'data' => new \DateTime()
            ])
            ->add('commentaire', TextType::class, [
                'required' => false
            ])
            ->add('nom_portail')
            ->add('desc_portail')
            ->add('img_portail', FileType::class, [
                'label' => 'Logo du portail',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '200k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => "Merci d'utiliser un JPEG ou un PNG",
                    ])
                ],
            ])
            ->add('modeleborne', EntityType::class,[
                'required' => false,
                'class'=>ModeleBorne::class,
                'choice_label' => function(ModeleBorne $modeleBorne) {
                    return sprintf('%s', $modeleBorne->getNom());
                },
                'placeholder' => 'Choisir modele'

            ])
            ->add('etat', EntityType::class,[
                'class'=>Etat::class,
                'choice_label' => function(Etat $etat) {
                    return sprintf('%s', $etat->getEtat());
                },
            ])
            ->add('serveur', EntityType::class,[
                'required' => false,
                'class'=>Serveur::class,
                'choice_label' => function(Serveur $serveur) {
                    return sprintf('(%d) %s', $serveur->getId(), $serveur->getReseaux());
                },
                'placeholder' => 'Choisir serveur'

            ])
            ->add('contact', EntityType::class,[
                'class'=>Contact::class,
                'choice_label' => function(Contact $contact) {
                    return sprintf('%s', $contact->getEmail());
                },
                'placeholder' => 'Selectionner un contact'

            ])
            /*->add('emplacement', EntityType::class,[
                'required' => false,
                'class'=>Emplacement::class,
                'query_builder' => function (EmplacementRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'DESC');
                },
                'choice_label' => function(Emplacement $emplacement) {
                    return sprintf('(%d) %s', $emplacement->getId(), $emplacement->getNomEtablissement());
                },
               // 'choices'=> $this->g->findByOrder(),
                'placeholder' => 'Choisir emplacement',


            ])*/
            ->add('flottes', EntityType::class,[
                'class'=>Flotte::class,
                'choice_label' => function(Flotte $flotte) {
                    return sprintf('%s', $flotte->getManager()->getEmail());
                },
                'placeholder' => 'Choisir manager',


            ])
            // ->add('nouveautes', EntityType::class,[
            //     'required' => false,
            //     'class'=>Nouveaute::class,
            //     'choice_label' => function(Nouveaute $nouveaute) {
            //         return sprintf('(%d) %s', $nouveaute->getId(), $nouveaute->getContenu());
            //     },
            //     'placeholder' => 'Choisir flotte'
            //
            // ])
            ->add('emplacement', EmplacementType::class)
            // ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Borne::class,
        ]);
    }
}
