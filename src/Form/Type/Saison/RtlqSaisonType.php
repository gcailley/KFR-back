<?php

namespace App\Form\Type\Saison;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Form\Type\AbstractRtlqType;
use App\Form\Type\Association\RtlqAdherentType;

class RtlqSaisonType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ( 'nom', TextType::class )
            ->add ( 'active', CheckboxType::class )
            ->add ( 'date_debut', DateType::class, $this->getDateFormatTZ())
            ->add ( 'date_fin', DateType::class, $this->getDateFormatTZ())
            ->add ('nb_adherents', NumberType::class)
            ->add ('adherents', CollectionType::class, array(
                'entry_type'   => RtlqAdherentType::class,
                //'allow_extra_fields' => true,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'label'         => false,
                'by_reference'  => false
            ));
    }
    public function getName()
    {
        return 'saison';
    }
}
