<?php

namespace App\Form\Type\Kungfu;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Form\Type\AbstractRtlqType;
use App\Form\Type\Association\RtlqAdherentType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RtlqKungfuTaoType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('nom_chinois', TextType::class)
            ->add('traduction', TextType::class)
            ->add('pinyin', TextType::class)
            ->add('origine', TextType::class)
            ->add('arme', TextType::class)
            ->add('video_url', TextType::class)
            ->add('style_id', NumberType::class)
            ->add('style_name', TextType::class)
            ->add('niveau_id', NumberType::class)
            ->add('niveau_name', TextType::class)
            ->add('combine', CheckBoxType::class)
            ->add('nb_moves', NumberType::class)
            ->add('actif', CheckBoxType::class)
            ->add('reference_drive_id', TextType::class)
            ->add('referents', CollectionType::class, [
                'entry_type' => RtlqAdherentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ]);
    }

    public function getName()
    {
        return 'kungfu-tao';
    }
}
