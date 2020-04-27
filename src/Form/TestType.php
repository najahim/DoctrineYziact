<?php

namespace App\Form;

use App\Entity\Borne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse_mac')
            ->add('nom')
            ->add('hostname')
            ->add('derniere_emission')
            ->add('ssid')
            ->add('Prog_wifi')
            ->add('channel')
            ->add('affichage_map')
            ->add('partage_stats')
            ->add('quota_user_duree')
            ->add('quota_user_max_bytes')
            ->add('filtrage')
            ->add('portail_url')
            ->add('upload_rate')
            ->add('download_rate')
            ->add('txpower')
            ->add('ip_adress_vpn_admin')
            ->add('date_mise_en_service')
            ->add('date_expiration_test')
            ->add('commentaire')
            ->add('modeleborne')
            ->add('etat')
            ->add('serveur')
            ->add('contact')
            ->add('emplacement')
            ->add('flottes')
            ->add('nouveautes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Borne::class,
        ]);
    }
}
