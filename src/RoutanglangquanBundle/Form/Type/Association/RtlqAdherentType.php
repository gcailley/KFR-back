<?php

namespace RoutanglangquanBundle\Form\Type\Association;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use RoutanglangquanBundle\Form\Type\AbstractRtlqType;

class RtlqAdherentType extends AbstractRtlqType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', EmailType::class)
                ->add('pwd', PasswordType::class)
                ->add('telephone', TextType::class)
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('date_naissance', DateType::class, $this->getDateFormat())
                ->add('actif', CheckBoxType::class)
                ->add('public', CheckBoxType::class)
                ->add('adresse', TextType::class)
                ->add('avatar', TextType::class)
                ->add('code_postal', TextType::class)
                ->add('ville', TextType::class)
                ->add('date_creation', DateType::class, $this->getDateFormat())
                ->add('date_last_auth', DateType::class, $this->getDateFormat())
                ->add('date_creation', DateType::class, $this->getDateFormat())
                ->add('groupes', CollectionType::class, array('entry_type' => NumberType::class))
                ->add('cotisations', CollectionType::class, array('entry_type' => NumberType::class));
    }

    public function getName() {
        return 'Adherent';
    }

}
