<?php

namespace App\Form\Type\Association;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\Type\AbstractRtlqType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RtlqEventType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ( 'description', TextType::class )
            ->add ( 'commentaire', TextType::class )
            ->add ( 'adresse', TextType::class )
            ->add ( 'date_creation', DateType::class, $this->getDateFormatTZ())
            ->add ( 'saison_id', TextType::class )
            ->add ( 'saison_name', TextType::class )
            ->add ( 'adherents', CollectionType::class, [
                   'entry_type' => RtlqAdherentType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'by_reference' => false, ]
                )
            ->add ( 'nb_accompagnants', NumberType::class );
    }
    public function getName()
    {
        return 'Event';
    }
}
