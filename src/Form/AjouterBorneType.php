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

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjouterBorneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse_mac')
            ->add('nom')
            ->add('hostname')
            ->add('derniere_emission',DateTimeType::class)
            ->add('ssid')
            ->add('Prog_wifi')
            ->add('channel', IntegerType::class)
            ->add('affichage_map', CheckboxType::class, [
                'required' => false
            ])
            ->add('partage_stats', CheckboxType::class, [
                'required' => false
            ])
            ->add('quota_user_duree',IntegerType::class)
            ->add('quota_user_max_bytes',IntegerType::class)
            ->add('filtrage',CheckboxType::class, [
                'required' => false
            ])
            ->add('portail_url')
            ->add('upload_rate')
            ->add('download_rate')
            ->add('txpower',IntegerType::class)
            ->add('ip_adress_vpn_admin')
            ->add('date_mise_en_service',DateTimeType::class)
            ->add('date_expiration_test',DateTimeType::class)
            ->add('commentaire')
            ->add('modeleborne', EntityType::class,[
                'required' => false,
                'class'=>ModeleBorne::class,
                'choice_label' => function(ModeleBorne $modeleBorne) {
                    return sprintf('(%d) %s', $modeleBorne->getId(), $modeleBorne->getNom());
                },
                'placeholder' => 'Choisir etat'

            ])
            ->add('etat', EntityType::class,[
                'required' => false,
                'class'=>Etat::class,
                'choice_label' => function(Etat $etat) {
                    return sprintf('(%d) %s', $etat->getId(), $etat->getEtat());
                },
                'placeholder' => 'Choisir etat'

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
                'required' => false,
                'class'=>Contact::class,
                'choice_label' => function(Contact $contact) {
                    return sprintf('(%d) %s', $contact->getId(), $contact->getNomDuContact());
                },
                'placeholder' => 'Choisir contact'

            ])
            ->add('emplacement', EntityType::class,[
                'required' => false,
                'class'=>Emplacement::class,
                'choice_label' => function(Emplacement $emplacement) {
                    return sprintf('(%d) %s', $emplacement->getId(), $emplacement->getNomEtablissement());
                },
                'placeholder' => 'Choisir emplacement'

            ])
            ->add('flottes', EntityType::class,[
                'required' => false,
                'class'=>Flotte::class,
                'choice_label' => function(Flotte $flotte) {
                    return sprintf('(%d) %s', $flotte->getId(), $flotte->getManager()->getEmail());
                },
                'placeholder' => 'Choisir flotte'

            ])
            ->add('nouveautes', EntityType::class,[
                'required' => false,
                'class'=>Nouveaute::class,
                'choice_label' => function(Nouveaute $nouveaute) {
                    return sprintf('(%d) %s', $nouveaute->getId(), $nouveaute->getContenu());
                },
                'placeholder' => 'Choisir flotte'

            ])
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Borne::class,
        ]);
    }
}
