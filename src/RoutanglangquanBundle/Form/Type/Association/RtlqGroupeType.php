<?php

namespace RoutanglangquanBundle\Form\Type\Association;

use RoutanglangquanBundle\Form\Type\AbstractRtlqType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RtlqGroupeType extends AbstractRtlqType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', TextType::class)
                ->add('adherents', CollectionType::class, array('entry_type' => NumberType::class));
    }

    public function getName() {
        return 'Groupe';
    }

}
