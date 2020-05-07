<?php

namespace App\Form;

use App\Entity\Borne;
use App\Entity\Contact;
use App\Entity\ModeleBorne;
use App\Entity\Flotte;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModifierBorneType extends AbstractType
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
            // ->add('date_mise_en_service',DateTimeType::class)
            // ->add('date_expiration_test',DateTimeType::class)
            ->add('commentaire', TextType::class, [
                'required' => false
            ])
            ->add('nom_portail')
            ->add('desc_portail')
            ->add('img_portail',FileType::class, [
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
            // ->add('etat', EntityType::class,[
            //     'required' => false,
            //     'class'=>Etat::class,
            //     'choice_label' => function(Etat $etat) {
            //         return sprintf('(%d) %s', $etat->getId(), $etat->getEtat());
            //     },
            //
            //     'placeholder' => 'Choisir etat',
            //
            // ])
            // ->add('serveur', EntityType::class,[
            //     'required' => false,
            //     'class'=>Serveur::class,
            //     'choice_label' => function(Serveur $serveur) {
            //         return sprintf('(%d) %s', $serveur->getId(), $serveur->getReseaux());
            //     },
            //     'placeholder' => 'Choisir serveur'
            //
            // ])
            ->add('contact', ContactBorneType::class,[
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
                'placeholder' => 'Choisir proprietaire'

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
