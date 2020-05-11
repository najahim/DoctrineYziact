<?php

namespace App\Form;

use App\Entity\VersionCGU;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('versioncgu')
            ->add('description_cgu')
            ->add('date_activation', DateType::class, [
                'data' => new \DateTime(),
                'widget' => 'single_text',
            ])
            //->add('active', CheckboxType::class, [
           // 'required' => false
           // ])
           //->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VersionCGU::class,
        ]);
    }
}
