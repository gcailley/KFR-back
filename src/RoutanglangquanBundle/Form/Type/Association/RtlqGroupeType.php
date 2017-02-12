<?php

namespace RoutanglangquanBundle\Form\Type\Association;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use RoutanglangquanBundle\Form\Type\AbstractRtlqType;

class RtlqGroupeType extends AbstractRtlqType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', EmailType::class)
                ->add('adherents', CollectionType::class, array('entry_type' => NumberType::class));
    }

    public function getName() {
        return 'Groupe';
    }

}
