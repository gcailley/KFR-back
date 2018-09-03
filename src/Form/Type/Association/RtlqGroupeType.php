<?php

namespace App\Form\Type\Association;

use App\Form\Type\AbstractRtlqType;
use App\Form\Type\Association\RtlqAdherentType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RtlqGroupeType extends AbstractRtlqType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('id', NumberType::class)
                ->add('nom', TextType::class)
                ->add('role', TextType::class)
                ->add('nb_adherents', NumberType::class)
                ->add('adherents', CollectionType::class, array(
                    'entry_type'   => RtlqAdherentType::class,
                    'allow_extra_fields' => true,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'prototype'     => true,
                    'label'         => false,
                    'by_reference'  => false
                    )
                );
    }

    public function getName()
    {
        return 'Groupe';
    }
}
