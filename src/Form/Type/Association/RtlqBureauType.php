<?php

namespace App\Form\Type\Association;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\Type\AbstractRtlqType;
use App\Form\Type\Saison\RtlqSaisonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RtlqBureauType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', NumberType::class)
            ->add('date_creation', DateType::class, $this->getDateFormatTZ())
            ->add('date_fin', DateType::class, $this->getDateFormatTZ())
            ->add('president_id', TextType::class)
            ->add('president_name', TextType::class)
            ->add('tresorier_id', TextType::class)
            ->add('tresorier_name', TextType::class)
            ->add('secretaire_id', TextType::class)
            ->add('secretaire_name', TextType::class)
            ->add('actif', CheckboxType::class)
            ->add(
                'saisons',
                CollectionType::class,
                [
                    'entry_type' => RtlqSaisonType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'by_reference' => false,
                ]
            );
    }

    public function getName()
    {
        return 'Bureau';
    }
}
