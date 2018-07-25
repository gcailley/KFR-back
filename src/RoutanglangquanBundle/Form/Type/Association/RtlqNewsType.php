<?php

namespace RoutanglangquanBundle\Form\Type\Association;

use RoutanglangquanBundle\Form\Type\AbstractRtlqType;
use RoutanglangquanBundle\Form\Type\Association\RtlqAdherentType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class RtlqNewsType extends AbstractRtlqType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', TextType::class)
                ->add('description', TextType::class)
                ->add('link', TextType::class)
                ->add('actif', CheckBoxType::class)
                ->add('date_creation', DateType::class, $this->getDateFormatTZ());
    }

    public function getName()
    {
        return 'News';
    }
}
